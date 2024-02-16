<?php

namespace Modules\Products\Http\Controllers\Traits;

use Illuminate\Support\Facades\Validator;

trait HasImages
{
    public function images(?array $data = null)
    {
        $images = [];

        if (is_null($data)) {
            return $images;
        }

        foreach ($data as $image) {
            $validator = $this->validateImages($image);

            if ($validator->fails()) {
                continue;
            }

            $images[] = $image;
        }
        return $images;
    }


    /**
     * Validate the discounts array.
     *
     * @param array $data The data to be validated
     * @throws Validation The validation instance
     * @return Validator The validator instance
     */
    private function validateImages(array $data)
    {
        return Validator::make($data, [
            'alt' => 'required',
            'url' => 'required',
        ]);
    }
}
