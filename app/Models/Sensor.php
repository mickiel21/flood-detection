<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'location',
        'status',
        'min_value',
        'max_value',
        'installation_date'
    ];

    /**
     * Filter to fetch the trashed items
     *
     * @var $query, array $filters
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['filter'] ?? null, function ($query, $filter) {
            if ($filter === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    public function getCreatedAtAttribute($value)
    {
        // Format the date using Carbon or any other date formatting method
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
