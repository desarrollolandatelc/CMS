<?php

namespace Modules\Titles\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Titles\Models\Title;

class TitleController extends Controller
{
    public function index()
    {
        $paginate = Title::paginate(12);
        return Inertia::render('Titles/Index', [
            'paginate' => $paginate
        ]);
    }
}
