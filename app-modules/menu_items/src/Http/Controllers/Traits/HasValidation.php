<?php

namespace Modules\MenuItems\Http\Controllers\Traits;

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
                    Rule::unique('menu_items', 'name')->ignore($id)
                ],
                'alias' => 'required',
                'module_id' => 'required|exists:modules,id',
                'href' => 'required',
                'internal_link' => 'required',
                'status' => 'required|boolean',
            ]
        );
    }
}
