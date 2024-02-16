<?php

namespace Modules\Brands\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\Traits\HasSearchable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Brands\Http\Controllers\Traits\HasValidation;
use Modules\Brands\Models\Brand;

class BrandController extends Controller
{
    use HasValidation, HasSearchable;

    public function index()
    {
        $paginate = Brand::paginate(12);
        return Inertia::render('Brand/Index', [
            'paginate' => $paginate
        ]);
    }


    public function create()
    {
        return Inertia::render('Brand/Create');
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
            return redirect()->route('brands.create')->withErrors($validator)->withInput();
        }

        Brand::create($validator->validated());

        return redirect()->route('brands.create')->with('success', 'Brand created successfully');
    }


    public function edit(Brand $brand)
    {
        return Inertia::render('Brand/Edit', [
            'brand' => $brand
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
    public function update(Request $request, Brand $brand)
    {
        $validator = $this->validate($request->all(), $brand->id);
        if ($validator->fails()) {
            return redirect()->route('brands.edit', $brand)->withErrors($validator)->withInput();
        }
        $brand->update($validator->validated());

        return redirect()->route('brands.edit', $brand)->with('success', 'Brand updated successfully');
    }

    public function bulkDestroy(Request $request)
    {
        Brand::destroy($request->ids);
        return redirect()->route('brands.index')->with('success', 'Brands deleted successfully.');
    }


    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully');
    }
}
