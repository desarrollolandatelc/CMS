<?php

namespace Modules\Fields\Http\Controllers\Traits;

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
                    Rule::unique('fields', 'name')->ignore($id)
                ],
                'alias' => 'required',
                'status' => 'required|boolean',
            ]
        );
    }
}
