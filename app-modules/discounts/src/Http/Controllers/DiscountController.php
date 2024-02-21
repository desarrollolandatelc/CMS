<?php

namespace Modules\Discounts\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Discounts\Http\Controllers\Traits\HasValidation;
use Modules\Discounts\Models\Discount;

class DiscountController extends Controller
{
    use HasValidation;

    public function index()
    {
        $paginate = Discount::paginate(12);
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

        Discount::create($validator->validated());

        return redirect()->route('discounts.create')->with('success', 'Discount created successfully');
    }


    public function edit(Discount $discount)
    {
        return Inertia::render('Discount/Edit', [
            'discounts' => $discount
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
}
