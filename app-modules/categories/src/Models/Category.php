<?php

namespace Modules\Categories\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'alias',
        'parent_id',
        'status',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
