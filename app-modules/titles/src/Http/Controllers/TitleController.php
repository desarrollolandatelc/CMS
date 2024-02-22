<?php

namespace Modules\Titles\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\Traits\HasSearchable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Titles\Http\Controllers\Traits\HasValidation;
use Modules\Titles\Models\Title;

class TitleController extends Controller
{
    use HasValidation, HasSearchable;
    public function index()
    {
        $paginate = Title::select('id', 'name', 'status')->paginate(12);
        return Inertia::render('Title/Index', [
            'paginate' => $paginate
        ]);
    }

    public function create()
    {
        return Inertia::render('Title/Create');
    }

    public function store(Request $request)
    {
        $validator = $this->validate($request->all());
        if ($validator->fails()) {
            return redirect()->route('titles.create')->withErrors($validator)->withInput();
        }
        $title = Title::create($validator->validated());

        return redirect()->route('titles.create')->with('success', 'Title created successfully');
    }

    public function edit(Title $title)
    {
        return Inertia::render('Title/Edit', [
            'title' => $title
        ]);
    }

    public function update(Title $title, Request $request)
    {
        $validator = $this->validate($request->all(), $title->id);
        if ($validator->fails()) {
            return redirect()->route('titles.edit', $title)->withErrors($validator)->withInput();
        }
        $title->update($validator->validated());
        return redirect()->route('titles.edit', $title)->with('success', 'Title updated successfully');
    }

    public function bulkDestroy(Request $request)
    {
        Title::destroy($request->ids);
        return redirect()->route('titles.index')->with('success', 'Titles deleted successfully.');
    }

    public function destroy(Title $title)
    {
        $title->delete();
        return redirect()->route('titles.index')->with('success', 'Title deleted successfully');
    }
}
