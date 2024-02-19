<?php

namespace Modules\ModuleTypes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'module_name',
        'status',
    ];
}
