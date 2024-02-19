<?php

namespace Modules\Site\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Site\Http\Controllers\Traits\HasValidation;
use Modules\Site\Models\Site;

class SiteController extends Controller
{
    use HasValidation;

    public function index()
    {
        $paginate = Site::paginate(12);
        return Inertia::render('Site/Index', [
            'paginate' => $paginate
        ]);
    }


    public function create()
    {
        return Inertia::render('Site/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function store(Request $request)
    {
        $validator = $this->validate($request->all());
        if ($validator->fails()) {
            return redirect()->route('sites.create')->withErrors($validator)->withInput();
        }

        Site::create($validator->validated());

        return redirect()->route('sites.create')->with('success', 'Site created successfully');
    }


    public function edit(Site $site)
    {
        return Inertia::render('Site/Edit', [
            'site' => $site
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Brand $brand
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function update(Request $request, Site $site)
    {
        $validator = $this->validate($request->all(), $site->id);
        if ($validator->fails()) {
            return redirect()->route('sites.edit', $site)->withErrors($validator)->withInput();
        }
        $site->update($validator->validated());

        return redirect()->route('sites.edit', $site)->with('success', 'Site updated successfully');
    }

    public function bulkDestroy(Request $request)
    {
        Site::destroy($request->ids);
        return redirect()->route('sites.index')->with('success', 'Sites deleted successfully.');
    }


    public function destroy(Site $site)
    {
        $site->delete();
        return redirect()->route('sites.index')->with('success', 'Site deleted successfully');
    }
}
