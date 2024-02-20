<?php

namespace Modules\Slider\Http\Controllers\Traits;

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
                'details' => 'nullable|array',
                'module_id' => 'required|exists:modules,id',
                'description' => 'required',
                'status' => 'required|boolean',
            ]
        );
    }
}
