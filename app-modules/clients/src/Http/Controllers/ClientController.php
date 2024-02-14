<?php

namespace Modules\Clients\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Clients\Http\Controllers\Traits\HasDiscounts;
use Modules\Clients\Models\Client;
use Modules\Providers\Http\Controllers\Traits\HasValidation;

class ClientController extends Controller
{
    use HasValidation, HasDiscounts;
    /**
     * Store a newly created client in storage.
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
        Client::create($request->all());
        return redirect()->route('clients.create')->with('success', 'Client created successfully.');
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
        $client = Client::find($id);
        $validator = $this->validate($request, $id);
        if ($validator->fails()) {
            return redirect()->route('clients.edit', $client->id)
                ->withErrors($validator)
                ->withInput();
        }

        $client->update($request->all());
        return redirect()->route('clients.edit', $client->id)->with('success', 'Client updated successfully.');
    }
}
