<?php

namespace Modules\Discounts\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Discounts\Http\Controllers\Traits\HasValidation;
use Modules\Discounts\Models\Discount;
use Modules\Products\Models\Product;

class DiscountController extends Controller
{
    use HasValidation;

    public function index()
    {
        $paginate = Discount::select('id', 'name', 'status')->paginate(12);
        return Inertia::render('Discount/Index', [
            'paginate' => $paginate
        ]);
    }


    public function create()
    {
        return Inertia::render('Discount/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function store(Request $request)
    {
        $validator = $this->validate($request->all());
        if ($validator->fails()) {
            return redirect()->route('discounts.create')->withErrors($validator)->withInput();
        }

        $this->validateIfProductHasDiscount($request);
        Discount::create($validator->validated());

        return redirect()->route('discounts.create')->with('success', 'Discount created successfully');
    }


    public function edit(Discount $discount)
    {
        return Inertia::render('Discount/Edit', [
            'discount' => $discount
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Brand $brand
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function update(Request $request, Discount $discount)
    {
        $validator = $this->validate($request->all(), $discount->id);
        if ($validator->fails()) {
            return redirect()->route('discounts.edit', $discount)->withErrors($validator)->withInput();
        }
        $discount->update($validator->validated());

        return redirect()->route('discounts.edit', $discount)->with('success', 'Discount updated successfully');
    }

    public function bulkDestroy(Request $request)
    {
        Discount::destroy($request->ids);
        return redirect()->route('discounts.index')->with('success', 'Discounts deleted successfully.');
    }


    public function destroy(Discount $brand)
    {
        $brand->delete();
        return redirect()->route('discounts.index')->with('success', 'Discount deleted successfully');
    }

    public function validateIfProductHasDiscount($request)
    {
        //Obtenemos los descuentos activos y que el día actual esté en el rango de fecha
        $discounts = Discount::where('status', 1)
            ->orWhere(function ($query) {
                $query->where('start_date', '<=', date('Y-m-d'))
                    ->where('end_date', '>=', date('Y-m-d'));
            })->get();

        $product = Product::where($request->product_field, $request->product_field_value);
        // Recorremos cada descuento
        foreach ($discounts as $discount) {
            $productWithDiscount = $product->where($discount->product_field,  $discount->product_field_value)
                ->count();
            if ($productWithDiscount > 0) {
                dd("holis, ya existe");
            }
            dd("no existe ñero");
        }
    }
}
