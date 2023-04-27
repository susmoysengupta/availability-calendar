<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Calendar extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'organization_id',
        'should_include_details',
        'hyperlink',
        'image_url',
        'description',
        'is_synced',
        'ical_feeds',
        'ical_feed_book_type',
        'should_split',
        'is_title_visible',
        'is_legend_visible',
        'passed_date_color',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'organization_id' => 'integer',
        'should_include_details' => 'boolean',
        'is_synced' => 'boolean',
        'ical_feeds' => 'array',
        'should_split' => 'boolean',
        'is_title_visible' => 'boolean',
        'is_legend_visible' => 'boolean',
    ];

    /**
     * Set the slug attribute.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Str::slug($model->title);
        });
    }

    /**
     * Get the legends for the calendar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function legends(): HasMany
    {
        return $this->hasMany(Legend::class);
    }

    /**
     * Get the organization that owns the calendar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organization_id', 'organization_id');
    }

    /**
     * Get the user that owns the calendar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the availabilities for the calendar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function availabilities(): HasMany
    {
        return $this->hasMany(Availability::class);
    }

    /**
     * Get the assigned users for the calendar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assignUser(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'calendar_user', 'calendar_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function editors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'calendar_user', 'calendar_id', 'user_id');
    }

    public function syncedLegends()
    {
        return [
            [
                'title' => 'Available',
                'color' => '#86efac',
                'split_color' => null,
                'is_default' => true,
                'is_synced' => false,
                'order' => 0,
            ],
            [
                'title' => 'Booked',
                'color' => '#fca5a5',
                'split_color' => null,
                'is_synced' => true,
                'order' => 1,
            ],
            [
                'title' => 'Changeover 1',
                'color' => '#86efac',
                'split_color' => '#fca5a5',
                'is_synced' => true,
                'order' => 2,
            ],
            [
                'title' => 'Changeover 2',
                'color' => '#fca5a5',
                'split_color' => '#86efac',
                'is_synced' => true,
                'order' => 3,
            ],
        ];
    }
}
