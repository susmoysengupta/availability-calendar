<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Legend extends Model
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
        'calendar_id',
        'color',
        'split_color',
        'is_default',
        'is_global',
        'is_visible',
        'is_synced',
        'order',
        'organization_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_default' => 'boolean',
        'is_global' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the calendar that owns the legend.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class);
    }

    /**
     * Get the organization that owns the legend.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organization_id', 'organization_id');
    }

    /**
     * Set the slug attribute.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Str::slug($model->title);
            $model->is_synced = (Str::lower($model->title) != 'available');
        });
    }

    /**
     * Scope a query to only global legends.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGlobal($query, $organizationId = null): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('is_global', true)
            ->where('calendar_id', null)
            ->when($organizationId, function ($query) use ($organizationId) {
                return $query->where('organization_id', $organizationId);
            });
    }

    /**
     * Scope a query to only default legend of a calendar.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDefault($query, Calendar $calendar): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('is_default', true)
            ->where('calendar_id', $calendar->id);
    }
}
