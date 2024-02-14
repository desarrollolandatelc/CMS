<?php

namespace Modules\Providers\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Providers\Http\Controllers\Traits\HasValidation;
use Modules\Providers\Models\Provider;

class ProviderController extends Controller
{
    use HasValidation;
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
            return redirect()->route('clients.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Assuming $clientModel is your Client model.
        // You would need to replace '$clientModel' with the actual model name.
        Provider::create($request->all());
        return redirect()->route('clients.create')->with('success', 'Provider created successfully.');
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
}
