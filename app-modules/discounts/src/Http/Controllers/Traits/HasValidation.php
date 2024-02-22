<?php

namespace Modules\Discounts\Http\Controllers\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait HasValidation
{
    public function validate(array $data, ?int $id = null)
    {
        return Validator::make(
            $data,
            [
                'name' => [
                    'required',
                    Rule::unique('brands', 'name')->ignore($id)
                ],
                'alias' => 'required',
                'product_field' => 'required',
                'table_field' => 'required',
                'product_field_value' => ['required', Rule::exists($data['table_field'], 'id')],
                'value' => 'required|numeric',
                'status' => 'required|boolean',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after:start_date'
            ]
        );
    }
}
