<?php

namespace Modules\Quotations\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Quotations\Http\Controllers\Traits\HasValidation;
use Modules\Quotations\Models\Quotation;

class QuotationController extends Controller
{
    use HasValidation;
    public function index()
    {
        $paginate = Quotation::paginate(12);
        return Inertia::render('Quotation/Index', [
            'paginate' => $paginate
        ]);
    }

    public function create()
    {
        return Inertia::render('Quotation/Create');
    }

    public function store(Request $request)
    {
        $validator = $this->validate($request->all());
        if ($validator->fails()) {
            return redirect()->route('quotations.create')->withErrors($validator)->withInput();
        }
        Quotation::create($request->all());
        return redirect()->route('quotations.create')->with('success', 'Quotation created successfully');
    }

    public function edit(Quotation $quotation)
    {
        $quotation->load('client', 'user');
        return Inertia::render('Quotation/Edit', [
            'quotation' => $quotation
        ]);
    }

    public function update(Request $request, Quotation $quotation)
    {
        $validator = $this->validate($request->all());
        if ($validator->fails()) {
            return redirect()->route('quotations.edit', $quotation)->withErrors($validator)->withInput();
        }
        $quotation->update($request->all());
        return redirect()->route('quotations.edit', $quotation)->with('success', 'Quotation updated successfully');
    }

    public function bulkDestroy(Request $request)
    {
        Quotation::destroy($request->ids);
        return redirect()->route('quotations.index')->with('success', 'Quotations deleted successfully.');
    }

    public function destroy(Quotation $quotation)
    {
        $quotation->delete();
        return redirect()->route('quotations.index')->with('success', 'Quotation deleted successfully');
    }
}
