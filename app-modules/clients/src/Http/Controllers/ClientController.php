<?php

namespace Modules\Clients\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Clients\Http\Controllers\Traits\HasDiscounts;
use Modules\Clients\Models\Client;
use Modules\Providers\Http\Controllers\Traits\HasValidation;

class ClientController extends Controller
{
    use HasValidation, HasDiscounts;

    /**
     * Show the form for creating a new client.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Client/Create');
    }

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

        Client::create($this->getDiscounts($request));
        return redirect()->route('clients.create')->with('success', 'Client created successfully.');
    }

    /**
     * Show the form for editing the specified client.
     *
     * @param int $id The client ID
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $client = Client::find($id);
        return Inertia::render('Client/Edit', [
            'client' => $client,
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
        $client = Client::find($id);
        $validator = $this->validate($request, $id);

        if ($validator->fails()) {
            return redirect()->route('clients.edit', $client->id)
                ->withErrors($validator)
                ->withInput();
        }

        $client->update($this->getDiscounts($request));
        return redirect()->route('clients.edit', $client->id)->with('success', 'Client updated successfully.');
    }

    /**
     * Get discounts from the request and return the updated data array.
     *
     * @param Request $request The request object
     * @return array
     */
    private function getDiscounts(Request $request): array
    {
        $discounts = $this->discounts($request->discounts);
        $data = $request->all();
        $data['discounts'] = $discounts;

        return $data;
    }

    /**
     * Destroy multiple clients from storage.
     *
     * @param Request $request The request data
     * @return \Illuminate\Http\Response
     */
    public function bulkDestroy(Request $request)
    {
        Client::destroy($request->ids);
        return redirect()->route('clients.index')->with('success', 'Clients deleted successfully.');
    }

    /**
     * Remove the specified client from storage.
     *
     * @param int $id The client ID
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $client = Client::find($id);
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }
}
