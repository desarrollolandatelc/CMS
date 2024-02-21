<?php

namespace Modules\Slider\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Slider\Http\Controllers\Traits\HasSlide;
use Modules\Slider\Http\Controllers\Traits\HasValidation;
use Modules\Slider\Models\Slider;

class SliderController extends Controller
{
    use HasValidation, HasSlide;

    public function index()
    {
        $paginate = Slider::paginate(12);
        return Inertia::render('Slider/Index', [
            'paginate' => $paginate
        ]);
    }


    public function create()
    {
        return Inertia::render('Slider/Create');
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
            return redirect()->route('sliders.create')->withErrors($validator)->withInput();
        }
        $data = $request->all();
        $data['details'] = $this->extraFields($request->details);
        
        Slider::create($data);

        return redirect()->route('sliders.create')->with('success', 'Brand created successfully');
    }


    public function edit(Slider $slider)
    {
        return Inertia::render('Slider/Edit', [
            'slider' => $slider
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
    public function update(Request $request, Slider $slider)
    {
        $validator = $this->validate($request->all(), $slider->id);
        if ($validator->fails()) {
            return redirect()->route('sliders.edit', $slider)->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['details'] = $this->extraFields($request->details);
        $slider->update($data);

        return redirect()->route('sliders.edit', $slider)->with('success', 'Slider updated successfully');
    }

    public function bulkDestroy(Request $request)
    {
        Slider::destroy($request->ids);
        return redirect()->route('sliders.index')->with('success', 'Sliders deleted successfully.');
    }


    public function destroy(Slider $brand)
    {
        $brand->delete();
        return redirect()->route('sliders.index')->with('success', 'Slider deleted successfully');
    }
}
