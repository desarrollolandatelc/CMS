<?php

namespace Modules\Products\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait HasValidation
{
    public function validate(Request $request, ?int $id = null)
    {

        return Validator::make($request->all(), [
            'brand_id' => 'required|exists:brands,id',
            'sku' => ['required', Rule::unique('products')->ignore($id)],
            'barcode' => ['required', Rule::unique('products')->ignore($id)],
            'description' => ['required'],
            'min_quantity' => ['required'],
            'max_quantity' => ['required'],
            'price' => ['required'],
            'images' => ['required'],
            'fields' => ['nullable', 'array'],
            'condition' => ['required', 'in:new,used'],
            'status' => ['required', 'in:0,1'],
            'category_id' => ['required', 'exists:categories,id'],
            'title_id' => ['required', 'exists:titles,id'],
            'currency_id' => ['required', 'exists:currencies,id'],
            'provider_id' => ['required', 'exists:providers,id'],
        ]);
    }
}
