<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'organization_id',
        'language_id',
        'week_start',
        'default_ordering',
        'per_page',
        'show_week_number',
        'calendar_timezone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the organization that owns the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organization_id', 'organization_id');
    }

    /**
     * Get the user's language.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get the calendars for the organization.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calendars(): HasMany
    {
        return $this->hasMany(Calendar::class, 'organization_id', 'organization_id');
    }

    /**
     * Get the assigned calendars for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assignedCalendars(): BelongsToMany
    {
        return $this->belongsToMany(Calendar::class, 'calendar_user', 'user_id', 'calendar_id')
            ->withTimestamps();
    }

    /**
     * Get the legends for the organization.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function legends(): HasMany
    {
        return $this->hasMany(Legend::class, 'organization_id', 'organization_id');
    }

    /**
     * Get the languages for the organization.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'language_user', 'organization_id', 'language_id')
            ->withTimestamps();
    }

    /**
     * Get the welcome message for the organization.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function welcomeMessage(): HasOne
    {
        return $this->hasOne(WelcomeMessage::class, 'organization_id', 'organization_id');
    }
}
