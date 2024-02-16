<?php

namespace Modules\Fields\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\Traits\HasSearchable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Fields\Http\Controllers\Traits\HasValidation;
use Modules\Fields\Models\Field;

class FieldController extends Controller
{
    use HasValidation, HasSearchable;
    public function index()
    {
        $paginate = Field::paginate(12);
        return Inertia::render('Field/Index', [
            'paginate' => $paginate
        ]);
    }

    public function create()
    {
        return Inertia::render('Field/Create');
    }

    public function store(Request $request)
    {

        $validator = $this->validate($request->all());
        if ($validator->fails()) {
            return redirect()->route('fields.create')->withErrors($validator)->withInput();
        }

        Field::create($validator->validated());

        return redirect()->route('fields.create')->with('success', 'Field created successfully');
    }

    public function edit(Field $field)
    {
        return Inertia::render('Field/Edit', [
            'field' => $field
        ]);
    }

    public function update(Field $field, Request $request)
    {

        $validator = $this->validate($request->all(), $field->id);
        if ($validator->fails()) {
            return redirect()->route('fields.edit', $field)->withErrors($validator)->withInput();
        }
        $field->update($validator->validated());

        return redirect()->route('fields.edit', $field)->with('success', 'Field updated successfully');
    }

    public function bulkDestroy(Request $request)
    {
        Field::destroy($request->ids);
        return redirect()->route('fields.index')->with('success', 'Fields deleted successfully.');
    }

    public function destroy(Field $field)
    {
        $field->delete();
        return redirect()->route('fields.index')->with('success', 'Field deleted successfully');
    }
}
