<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Products\Http\Controllers\Traits\HasExtraFields;
use Modules\Products\Http\Controllers\Traits\HasImages;
use Modules\Products\Http\Controllers\Traits\HasValidation;
use Modules\Products\Models\Product;

class ProductController extends Controller
{
    use HasValidation, HasExtraFields, HasImages;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = Product::select('products.id', 'barcode', 'sku', 'titles.name as title', 'price', 'products.status',)
            ->join('titles', 'titles.id', '=', 'products.title_id')->paginate(12);
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
        $data = $this->getAllData($request);

        Product::create($data);
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
        $data = $this->getAllData($request);

        $product->update($data);
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

    private function getAllData(Request $request)
    {
        $images = $this->images($request->images);
        $fields = $this->extraFields($request->fields);

        $data = $request->all();
        $data['images'] = $images;
        $data['fields'] = $fields;

        return $data;
    }

    /**
     * Get discounts from the request and return the updated data array.
     *
     * @param Request $request The request object
     * @return array
     */
    private function getImages(Request $request): array
    {
        return $this->images($request->images);
    }

    /**
     * Get discounts from the request and return the updated data array.
     *
     * @param Request $request The request object
     * @return array
     */
    private function getExtraFields(Request $request): array
    {
        return $this->extraFields($request->fields);
    }

    public function search(Request $request)
    {
        $querySearch = $request->get('query');
        $products = Product::join('titles', 'titles.id', '=', 'products.title_id')
            ->join('providers', 'providers.id', '=', 'products.provider_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where('titles.name', 'like', '%' . $querySearch . '%')
            ->select('products.id', 'products.images', 'products.barcode', 'products.sku', 'titles.name as name', 'products.price',  'providers.id', 'brands.name as brand_name')
            ->get();
        return response()->json($products);
    }
}
