<?php

namespace App\Http\Services\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait HasSearchable
{

    public function search(Request $request)
    {
        $query = $request->get('query');
        $table = $request->get('table');
        $providers = DB::table($table)->where('name', 'like', '%' . $query . '%')->limit(12);

        return response()->json($providers->get());
    }
}
