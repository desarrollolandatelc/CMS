<?php

namespace Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Brands\Models\Brand;
use Modules\Categories\Models\Category;
use Modules\Currencies\Models\Currency;
use Modules\Providers\Models\Provider;
use Modules\Titles\Models\Title;

class Product extends Model
{
    use HasFactory,  SoftDeletes;


    protected $fillable = [
        'sku',
        'barcode',
        'description',
        'min_quantity',
        'max_quantity',
        'price',
        'category_id',
        'title_id',
        'currency_id',
        'brand_id',
        'provider_id',
        'images',
        'fields',
        'condition',
        'status',
    ];

    protected function casts()
    {
        return [
            'fields' => 'array',
            'images' => 'array',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function title()
    {
        return $this->belongsTo(Title::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
