<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SetPasswordController extends Controller
{
    /**
     * @param Request $request
     */
    public function create(Request $request)
    {
        return view('auth.set-password');
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        auth()->user()->update(['password' => bcrypt($request->password)]);

        return redirect()->route('calendars.index')->with('success', 'Password set successfully');
    }
}
