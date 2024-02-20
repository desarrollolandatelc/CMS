<?php

namespace Modules\Slider\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'alias',
        'status',
        'module_id',
        'details',
        'description',
    ];

    protected function casts()
    {
        return [
            'details' => 'array',
        ];
    }
}
