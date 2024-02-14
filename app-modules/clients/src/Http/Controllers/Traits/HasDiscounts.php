<?php


namespace Modules\Clients\Http\Controllers\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as Validation;

trait HasDiscounts
{

    /**
     * A description of the entire PHP function.
     *
     * @param array $data description
     * @return array
     */
    protected function discounts(array $data): array
    {
        $discounts = [];
        foreach ($data as $discount) {
            $validator = $this->validateDiscounts($discount);

            if ($validator->fails()) {
                continue;
            }

            $discounts[] = $discount;
        }
        return $discounts;
    }

    private function validateDiscounts(array $data): Validation
    {
        return Validator::make($data, [
            'provider_name' => 'required|exists:providers,name',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);
    }
}
