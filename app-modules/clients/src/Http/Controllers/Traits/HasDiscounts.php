<?php


namespace Modules\Clients\Http\Controllers\Traits;

use Illuminate\Support\Facades\Validator;

trait HasDiscounts
{


    /**
     * Permite filtrar cada descuento de un cliente
     * con el fin de garantizar la integridad de
     * cada descuento
     *
     * @param array $data 
     * @return array
     */
    protected function discounts(?array $data = null): array
    {
        $discounts = [];

        if (is_null($data)) {
            return $discounts;
        }

        foreach ($data as $discount) {
            $validator = $this->validateDiscounts($discount);

            if ($validator->fails()) {
                continue;
            }

            $discounts[] = $discount;
        }
        return $discounts;
    }

    /**
     * Validate the discounts array.
     *
     * @param array $data The data to be validated
     * @throws Validation The validation instance
     * @return Validator The validator instance
     */
    private function validateDiscounts(array $data)
    {
        return Validator::make($data, [
            'provider.id' => 'required|exists:providers,id',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);
    }
}
