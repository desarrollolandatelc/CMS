<?php

namespace Modules\ModuleTypes\Http\Controllers\Traits;

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
                'module_name' => 'required',
                'status' => 'required|boolean',
            ]
        );
    }
}
