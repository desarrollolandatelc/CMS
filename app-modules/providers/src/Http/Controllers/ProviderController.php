<?php

namespace Modules\Providers\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Providers\Models\Provider;

class ProviderController extends Controller
{
    /**
     * Store a newly created provider in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('providers', 'name')->where(function ($query) use ($request) {
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
        Provider::create($request->all());
        return redirect()->route('clients.create')->with('success', 'Provider created successfully.');
    }
}
