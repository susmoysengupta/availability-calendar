<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\AppSetting;
use App\Models\Language;
use App\Models\User;
use App\Models\WelcomeMessage;
use App\Notifications\TeamInviteNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $users = User::query()
            ->where('organization_id', auth()->user()->organization_id)
            ->with('roles')
            ->when(request()->search, fn($query, $search) => $query->where('name', 'like', "%{$search}%"))
            ->orderByRaw('id = ' . auth()->user()->id . ' DESC')
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        $languages = auth()->user()->organization->languages->pluck('name', 'id');
        $roles = Role::query()
            ->whereNot('name', 'super-admin')
            ->whereNot('name', 'super-user')
            ->pluck('name', 'id');
        $calendars = auth()->user()->calendars->pluck('title', 'id');

        return view('users.create', compact('languages', 'roles', 'calendars'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        $user = User::create($request->validated() + [
            'organization_id' => auth()->user()->organization_id,
            'password' => 'secret',
        ])->assignRole($request->role_id);

        $editorRoleId = Role::query()->where('name', 'editor')->first()->id ?? -1;

        if ($request->role_id === $editorRoleId) {
            $user->assignedCalendars()->sync($request->calendars);
        }

        if ($request->can_update_profile) {
            $user->givePermissionTo('update-profile');
        }
        if ($request->can_update_legend) {
            $user->givePermissionTo('update-legend');
        }

        $user->assignedCalendars()->sync($request->calendars);

        $inviteUrl = URL::signedRoute('accept_invitation', $user);

        $message = AppSetting::query()
            ->where('key', 'welcome_message')
            ->first()?->value;
        $userTranslatedMessage = WelcomeMessage::query()
            ->where('organization_id', $user->organization_id)
            ->first()[$user->language->code] ?? null;

        if ($userTranslatedMessage) {
            $message = $userTranslatedMessage;
        }

        $welcomeMessage = __($message, [
            'superuser.name' => auth()->user()->name,
            'superuser.email' => auth()->user()->email,
            'user.name' => $user->name,
            'user.email' => $user->email,
            'site.login_url' => "<a href='{$inviteUrl}' class='text-blue-500 font-medium'>{$inviteUrl}</a>",
        ]);

        $user->notify(new TeamInviteNotification($inviteUrl, $welcomeMessage));

        DB::commit();

        return redirect()->route('users.index')->with('success', __('User has been created.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user): View
    {
        if ($user->organization_id !== auth()->user()->organization_id) {
            abort(404, 'User not found.');
        }

        if ($user->id === auth()->user()->id) {
            return redirect()->route('profile.edit');
        }

        $languages = auth()->user()->organization->languages->pluck('name', 'id');
        $roles = Role::query()
            ->whereNot('name', 'super-admin')
            ->whereNot('name', 'super-user')
            ->pluck('name', 'id');
        $calendars = auth()->user()->calendars->pluck('title', 'id');
        $userRole = $user->roles->first()->id;

        return view('users.edit', compact(
            'user',
            'languages',
            'roles',
            'calendars',
            'userRole'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        if ($user->organization_id !== auth()->user()->organization_id) {
            abort(404, 'User not found.');
        }

        if ($user->id === auth()->user()->id) {
            return redirect()->route('profile.edit');
        }

        DB::beginTransaction();
        $user->update($request->validated());

        $editorRoleId = Role::query()->where('name', 'editor')->first()->id ?? -1;

        if ((int) $request->role_id === $editorRoleId) {
            $user->assignedCalendars()->sync($request->calendars);
        } else {
            $user->assignedCalendars()->sync([]);
        }

        $user->syncRoles($request->role_id);

        if ($request->can_update_profile) {
            $user->givePermissionTo('update-profile');
        } else {
            $user->revokePermissionTo('update-profile');
        }

        if ($request->can_update_legend) {
            $user->givePermissionTo('update-legend');
        } else {
            $user->revokePermissionTo('update-legend');
        }

        DB::commit();

        return redirect()->route('users.index')->with('success', __('User has been updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->user()->id) {
            return redirect()->route('users.index')->with('error', __('You cannot delete yourself.'));
        }

        if ($user->organization_id !== auth()->user()->organization_id) {
            abort(404, 'User not found.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', __('User has been deleted.'));
    }

    /**
     * @param Request $request
     * @param User $user
     */
    public function updatePassword(Request $request, User $user)
    {
        if ($user->organization_id !== auth()->user()->organization_id) {
            abort(404, 'User not found.');
        }

        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index')->with('success', __('Password has been updated.'));
    }

    /**
     * @param Request $request
     */
    public function acceptInvitation(User $user, Request $request): RedirectResponse
    {
        if (!$request->hasValidSignature() || $user->password != 'secret') {
            abort(401);
        }

        auth()->login($user);

        return redirect()->route('calendars.index')->with('success', __('You are in the team now.'));
    }
}
