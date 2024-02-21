<?php

namespace Modules\Slider\Http\Controllers\Traits;

use Illuminate\Support\Facades\Validator;

trait HasSlide
{
    public function extraFields(?array $data = null)
    {
        //dd($data);
        $slides = [];

        if (is_null($data)) {
            return $slides;
        }

        foreach ($data as $field) {
            $validator = $this->validateFields($field);

            if ($validator->fails()) {
                continue;
            }

            $slides[] = $field;
        }

        return $slides;
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
            'alt' => 'required',
            'path' => 'required',
            'menu_item' => 'required|array'
        ]);
    }
}
