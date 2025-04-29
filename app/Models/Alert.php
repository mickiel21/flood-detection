<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sensor;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alert extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'sensor_id', 'type', 'severity', 'message'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }

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
