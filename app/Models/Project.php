<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'business_type',
        'status',
        'investment_time',
        'duration',
        'start_date',
        'mature_date',
        'goal',
        'minimum_investment',
        'raised',
        'roi',
        'image',
        'gallery',
        'summary',
        'description',
        'market_opportunity',
        'risk_factors',
        'is_live',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'mature_date' => 'date',
            'goal' => 'decimal:2',
            'minimum_investment' => 'decimal:2',
            'raised' => 'decimal:2',
            'gallery' => 'array',
            'is_live' => 'boolean',
        ];
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
