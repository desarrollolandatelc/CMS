<?php

namespace Modules\Products\Http\Controllers\Traits;

use Illuminate\Support\Facades\Validator;

trait HasExtraFields
{
    public function extraFields(?array $data = null)
    {
        $extraFields = [];

        if (is_null($data)) {
            return $extraFields;
        }

        foreach ($data as $field) {
            $validator = $this->validateFields($field);

            if ($validator->fails()) {
                continue;
            }

            $extraFields[] = $field;
        }
        return $extraFields;
    }


    /**
     * Validate the discounts array.
     *
     * @param array $data The data to be validated
     * @throws Validation The validation instance
     * @return Validator The validator instance
     */
    private function validateFields(array $data)
    {
        return Validator::make($data, [
            'field.id' => 'required|exists:fields,id',
            'value' => 'required',
        ]);
    }
}
