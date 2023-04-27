<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Language extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'native_name',
        'country',
        'country_code',
    ];

    /**
     * Get the users for the language.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'language_user', 'language_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Get the organizations for the language.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'language_user', 'language_id', 'organization_id')
            ->withTimestamps();
    }
}
