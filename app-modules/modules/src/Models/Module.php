<?php

namespace Modules\Modules\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\ModuleTypes\Models\ModuleType;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'alias',
        'status',
        'module_type_id',
        'position',
        'view_path',
    ];

    public function module_type()
    {
        return $this->belongsTo(ModuleType::class);
    }
}
