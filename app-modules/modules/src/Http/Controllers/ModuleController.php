<?php

namespace Modules\Modules\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\Traits\HasSearchable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Modules\Http\Controllers\Traits\HasValidation;
use Modules\Modules\Models\Module;

class ModuleController extends Controller
{
    use HasValidation, HasSearchable;

    public function index()
    {
        $paginate = Module::paginate(12);
        return Inertia::render('Module/Index', [
            'paginate' => $paginate
        ]);
    }


    public function create()
    {
        return Inertia::render('Module/Create');
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
            return redirect()->route('modules.create')->withErrors($validator)->withInput();
        }

        Module::create($validator->validated());

        return redirect()->route('modules.create')->with('success', 'Module created successfully');
    }


    public function edit(Module $module)
    {
        $module->load('module_type');
        return Inertia::render('Module/Edit', [
            'module' => $module
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
    public function update(Request $request, Module $module)
    {
        $validator = $this->validate($request->all(), $module->id);
        if ($validator->fails()) {
            return redirect()->route('modules.edit', $module)->withErrors($validator)->withInput();
        }
        $module->update($validator->validated());

        return redirect()->route('modules.edit', $module)->with('success', 'Module updated successfully');
    }

    public function bulkDestroy(Request $request)
    {
        Module::destroy($request->ids);
        return redirect()->route('modules.index')->with('success', 'Modules deleted successfully.');
    }


    public function destroy(Module $brand)
    {
        $brand->delete();
        return redirect()->route('modules.index')->with('success', 'Module deleted successfully');
    }
}
