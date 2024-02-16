<?php

namespace Modules\Clients\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\DocumentTypes\Models\DocumentType;
use Modules\PersonTypes\Models\PersonType;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'alias',
        'email',
        'document_number',
        'person_type_id',
        'document_type_id',
        'address',
        'phone',
        'status',
        'discounts',
    ];


    protected function casts()
    {
        return [
            'discounts' => 'array',
        ];
    }

    public function personType()
    {
        return $this->belongsTo(PersonType::class);
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
