<?php

namespace Modules\PersonTypes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\DocumentTypes\Models\DocumentType;

class PersonType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'alias',
        'status'
    ];


    public function documentTypes()
    {
        return $this->hasMany(DocumentType::class);
    }
}
