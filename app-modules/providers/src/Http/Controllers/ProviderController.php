<?php

namespace Modules\Providers\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Modules\Providers\Http\Controllers\Traits\HasValidation;
use Modules\Providers\Models\Provider;

class ProviderController extends Controller
{
    use HasValidation;

    /**
     * Display a listing of the providers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $providers = Provider::paginate(12);
        return Inertia::render('Provider/Index', [
            'providers' => $providers
        ]);
    }


    /**
     * Show the form for creating a new provider.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Provider/Create');
    }
    /**
     * Store a newly created provider in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = $this->validate($request);

        if ($validator->fails()) {
            return redirect()->route('providers.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Assuming $clientModel is your Client model.
        // You would need to replace '$clientModel' with the actual model name.
        Provider::create($request->all());
        return redirect()->route('providers.create')->with('success', 'Provider created successfully.');
    }

    /**
     * Show the form for editing the specified provider.
     *
     * @param int $id The provider ID
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $provider = Provider::find($id);
        return Inertia::render('Provider/Edit', [
            'provider' => $provider,
        ]);
    }

    /**
     * Update a provider based on the given request and id.
     *
     * @param Request $request The request data
     * @param int $id The provider ID
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $provider = Provider::find($id);
        $validator = $this->validate($request, $id);
        if ($validator->fails()) {
            return redirect()->route('providers.edit', $provider->id)
                ->withErrors($validator)
                ->withInput();
        }

        $provider->update($request->all());
        return redirect()->route('providers.edit', $provider->id)->with('success', 'Provider updated successfully.');
    }

    /**
     * Remove multiple providers from storage.
     *
     * @param Request $request The request data
     * @return \Illuminate\Http\Response
     */
    public function bulkDestroy(Request $request)
    {
        Provider::destroy($request->ids);
        return redirect()->route('providers.index')->with('success', 'Providers deleted successfully.');
    }

    /**
     * Destroy a provider by its ID.
     *
     * @param datatype $id description
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $provider = Provider::find($id);
        $provider->delete();
        return redirect()->route('providers.index')->with('success', 'Provider deleted successfully.');
    }
}
