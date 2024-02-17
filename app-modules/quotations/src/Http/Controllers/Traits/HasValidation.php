<?php

namespace Modules\Quotations\Http\Controllers\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait HasValidation
{
    public function validate(array $data, ?int $id = null)
    {
        return Validator::make(
            $data,
            [
                'user_id' => ['required', 'exists:users,id'],
                'client_id' => ['required', 'exists:clients,id'],
                'status' => 'required|in:pending,accepted,rejected',
                'details' => 'required|array',
            ]
        );
    }
}
