<?php

namespace Modules\ModuleTypes\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\Traits\HasSearchable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\ModuleTypes\Http\Controllers\Traits\HasValidation;
use Modules\ModuleTypes\Models\ModuleType;

class ModuleTypeController extends Controller
{
    use HasValidation, HasSearchable;

    public function index()
    {
        $paginate = ModuleType::paginate(12);
        return Inertia::render('ModuleType/Index', [
            'paginate' => $paginate
        ]);
    }


    public function create()
    {
        return Inertia::render('ModuleType/Create');
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
            return redirect()->route('module-types.create')->withErrors($validator)->withInput();
        }

        ModuleType::create($validator->validated());

        return redirect()->route('module-types.create')->with('success', 'Module type created successfully');
    }


    public function edit(ModuleType $moduleType)
    {
        return Inertia::render('ModuleType/Edit', [
            'moduleType' => $moduleType
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
    public function update(Request $request, ModuleType $moduleType)
    {
        $validator = $this->validate($request->all(), $moduleType->id);
        if ($validator->fails()) {
            return redirect()->route('module-types.edit', $moduleType)->withErrors($validator)->withInput();
        }
        $moduleType->update($validator->validated());

        return redirect()->route('module-types.edit', $moduleType)->with('success', 'Module type updated successfully');
    }

    public function bulkDestroy(Request $request)
    {
        ModuleType::destroy($request->ids);
        return redirect()->route('module-types.index')->with('success', 'Module types deleted successfully.');
    }


    public function destroy(ModuleType $moduleType)
    {
        $moduleType->delete();
        return redirect()->route('module-types.index')->with('success', 'Module type deleted successfully');
    }
}
