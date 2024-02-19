<?php

namespace Modules\MenuItems\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Modules\Models\Module;

class MenuItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'alias',
        'href',
        'status',
        'internal_link',
        'parent_id',
        'module_id',
    ];


    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }


    public function childrens(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
