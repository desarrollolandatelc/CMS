<?php

namespace Modules\Clients\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Clients\Models\Client;

class ClientController extends Controller
{
    /**
     * Store a newly created client in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('clients', 'name')->where(function ($query) use ($request) {
                    $query->where('document_number', $request->document_number);
                })
            ],
            'document_number' => 'required',
            'email' => 'required|email',
            'status' => 'required|boolean',
            'alias' => 'required',
            'person_type_id' => 'required|exists:person_types,id',
            'document_type_id' => 'required|exists:document_types,id',
        ]);

        // Assuming $clientModel is your Client model.
        // You would need to replace '$clientModel' with the actual model name.
        Client::create($request->all());
        return redirect()->route('clients.create')->with('success', 'Client created successfully.');
    }
}
