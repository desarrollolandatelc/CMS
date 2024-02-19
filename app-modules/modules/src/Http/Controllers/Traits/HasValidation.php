<?php

namespace Modules\Modules\Http\Controllers\Traits;

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
                'module_type_id' => 'required|exists:module_types,id',
                'view_path' => 'required',
                'status' => 'required|boolean',
                'position' => 'nullable',
            ]
        );
    }
}
