<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Availability extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'day',
        'month_year',
        'start',
        'calendar_id',
        'user_id',
        'legend_id',
        'remarks',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'day' => 'integer',
        'calendar_id' => 'integer',
        'user_id' => 'integer',
        'legend_id' => 'integer',
    ];

    /**
     * Get the calendar that owns the availability.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class);
    }

    /**
     * Get the user that owns the availability.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the legend that owns the availability.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function legend(): BelongsTo
    {
        return $this->belongsTo(Legend::class);
    }
}
