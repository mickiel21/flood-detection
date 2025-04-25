<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomRole extends Role
{
    use HasFactory , SoftDeletes;

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
