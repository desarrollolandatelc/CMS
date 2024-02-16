<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Products\Http\Controllers\Traits\HasValidation;
use Modules\Products\Models\Product;

class ProductController extends Controller
{
    use HasValidation;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = Product::paginate(12);
        return Inertia::render('Product/Index', [
            'paginate' => $paginate
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Product/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validate($request);
        if ($validator->fails()) {
            return redirect()->route('products.create')->withErrors($validator)->withInput();
        }
        Product::create($validator->validated());
        return redirect()->route('products.create')->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $product->load('brand', 'category', 'currency', 'provider', 'title');
        return Inertia::render('Product/Edit', [
            'product' => $product
        ]);
    }

    public function update(Product $product, Request $request)
    {
        $validator = $this->validate($request, $product->id);
        if ($validator->fails()) {
            return redirect()->route('products.edit', $product->id)->withErrors($validator)->withInput();
        }
        $product->update($validator->validated());
        return redirect()->route('products.edit', $product->id)->with('success', 'Product updated successfully');
    }

    public function bulkDestroy(Request $request)
    {
        Product::destroy($request->ids);
        return redirect()->route('products.index')->with('success', 'Products deleted successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
