<?php

namespace Modules\Currencies\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\Traits\HasSearchable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Currencies\Http\Controllers\Traits\HasValidation;
use Modules\Currencies\Models\Currency;

class CurrencyController extends Controller
{
    use HasValidation, HasSearchable;
    public function index()
    {
        $paginate = Currency::paginate(12);
        return Inertia::render('Currency/Index', [
            'paginate' => $paginate
        ]);
    }

    public function create()
    {
        return Inertia::render('Currency/Create');
    }

    public function store(Request $request)
    {
        $validator = $this->validate($request->all());

        if ($validator->fails()) {
            return redirect()->route('currencies.create')->withErrors($validator)->withInput();
        }

        Currency::create($validator->validated());

        return redirect()->route('currencies.create');
    }

    public function edit(Currency $currency)
    {
        return Inertia::render('Currency/Edit', [
            'currency' => $currency
        ]);
    }

    public function update(Request $request, Currency $currency)
    {
        $validator = $this->validate($request->all(), $currency->id);

        if ($validator->fails()) {
            return redirect()->route('currencies.edit', $currency)->withErrors($validator)->withInput();
        }

        $currency->update($validator->validated());

        return redirect()->route('currencies.edit', $currency)->with('success', 'Currency updated successfully');
    }

    public function bulkDestroy(Request $request)
    {
        Currency::destroy($request->ids);
        return redirect()->route('brands.index')->with('success', 'Currencies deleted successfully.');
    }


    public function destroy(Currency $currency)
    {
        $currency->delete();
        return redirect()->route('currencies.index')->with('success', 'Currency deleted successfully.');
    }

    public function getAllFromApi()
    {

        $currencies = Currency::all();
        return response()->json($currencies);
    }
}
