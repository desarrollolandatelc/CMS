<?php

namespace Modules\DocumentTypes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\PersonTypes\Models\PersonType;

class DocumentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'alias',
        'status'
    ];

    public function personType()
    {
        return $this->belongsTo(PersonType::class);
    }
}
