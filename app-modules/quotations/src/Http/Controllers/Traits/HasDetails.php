<?php

namespace Modules\Quotations\Http\Controllers\Traits;

use Illuminate\Support\Facades\Validator;
use Modules\Clients\Models\Client;
use Modules\Products\Models\Product;

trait HasDetails
{
    public function details(?array $data = null)
    {
        $details = [];

        if (is_null($data)) {
            return $details;
        }

        // Obtenemos todos los descuentos del cliente
        $discounts = Client::find($data['client_id'])->discounts;
        $providerAdded = [];
        foreach ($discounts as $discount) {
            $providerAdded[$discount['provider']['id']] = $discount['percentage'];
        }
        // almacenamos en cache cada producto registrado en el descuento
        $productsToSearch = [];
        $productsAdded = [];
        foreach ($data['details'] as $value) {
            // Almacenamos cada producto que queremos buscar en masa
            // Almacenamos los productos que no estén duplicados en el
            // detalle de la cotización
            if (isset($productsAdded[$value['barcode']])) continue;
            $productsToSearch[] = $value['barcode'];
            $productsAdded[$value['barcode']] = $value['quantity'];
        }

        // Buscamos todos los productos para realizar la respectiva comprobación
        $products = Product::whereIn('barcode', $productsToSearch)->get();
        foreach ($products as $product) {
            if ($providerAdded[$product->provider_id]) {
                $details[] = [
                    'barcode' => $product->barcode,
                    'title' => $product->title->name,
                    'price' => $product->price,
                    'quantity' => $productsAdded[$product->barcode],
                    'discount' => $providerAdded[$product->provider_id]
                ];
            }
        }
        return $details;
    }


    /**
     * Validate the discounts array.
     *
     * @param array $data The data to be validated
     * @throws Validation The validation instance
     * @return Validator The validator instance
     */
    private function validateDetail(array $data)
    {
    }
}
