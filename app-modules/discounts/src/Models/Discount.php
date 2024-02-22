<?php

namespace Modules\Discounts\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'alias',
        'product_field',
        'product_field_value',
        'value',
        'start_date',
        'end_date',
        'status',
    ];
}
