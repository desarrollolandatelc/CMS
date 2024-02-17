<?php

namespace Modules\Quotations\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Clients\Models\Client;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'status',
        'details',
    ];

    protected function casts()
    {
        return [
            'details' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}
