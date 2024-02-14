<?php

namespace Modules\Providers\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait HasValidation
{
    public function validate(Request $request, ?int $id = null)
    {

        return Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('clients', 'name')->where(function ($query) use ($request) {
                    $query->where('document_number', $request->document_number);
                })->ignore($id),
            ],
            'document_number' => 'required',
            'email' => 'required|email',
            'status' => 'required|boolean',
            'alias' => 'required',
            'person_type_id' => 'required|exists:person_types,id',
            'document_type_id' => 'required|exists:document_types,id',
        ]);
    }
}
