<?php

namespace Modules\Providers\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'alias',
        'document_number',
        'document_type_id',
        'person_type_id',
        'email',
        'phone',
        'address',
        'status',
    ];
}
