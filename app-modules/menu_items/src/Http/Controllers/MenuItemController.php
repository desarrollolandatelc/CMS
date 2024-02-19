<?php

namespace Modules\MenuItems\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\Traits\HasSearchable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\MenuItems\Http\Controllers\Traits\HasValidation;
use Modules\MenuItems\Models\MenuItem;

class MenuItemController extends Controller
{
    use HasValidation, HasSearchable;

    public function index()
    {
        $paginate = MenuItem::paginate(12);
        return Inertia::render('MenuItem/Index', [
            'paginate' => $paginate
        ]);
    }


    public function create()
    {
        return Inertia::render('MenuItem/Create');
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
            return redirect()->route('menu-items.create')->withErrors($validator)->withInput();
        }

        MenuItem::create($validator->validated());

        return redirect()->route('menu-items.create')->with('success', 'MenuItem created successfully');
    }


    public function edit(MenuItem $menuItem)
    {
        return Inertia::render('MenuItem/Edit', [
            'menuItem' => $menuItem
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
    public function update(Request $request, MenuItem $menuItem)
    {
        $validator = $this->validate($request->all(), $menuItem->id);
        if ($validator->fails()) {
            return redirect()->route('menu-items.edit', $menuItem)->withErrors($validator)->withInput();
        }
        $menuItem->update($validator->validated());

        return redirect()->route('menu-items.edit', $menuItem)->with('success', 'MenuItem updated successfully');
    }

    public function bulkDestroy(Request $request)
    {
        MenuItem::destroy($request->ids);
        return redirect()->route('brands.index')->with('success', 'Menu items deleted successfully.');
    }


    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        return redirect()->route('menu-items.index')->with('success', 'Menu item deleted successfully');
    }

    public function getAllByModuleId(Request $request)
    {
        $menuItems = MenuItem::where('module_id', $request->module_id)->get();
        return response()->json($menuItems);
    }
}
