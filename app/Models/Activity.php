<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    public const STATUSES = [
        'Planned',
        'Ongoing',
        'Done',
    ];

    protected $fillable = [
        'title',
        'description',
        'activity_date',
        'category',
        'category_id',
        'status',
    ];

    public function category(): BelongsTo
    {
    return $this->belongsTo(Category::class);
    }

    public function registrations(): HasMany
    {
    return $this->hasMany(Registration::class);
    }
}
