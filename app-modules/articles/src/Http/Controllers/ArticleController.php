<?php

namespace Modules\Articles\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Articles\Http\Controllers\Traits\HasValidation;
use Modules\Articles\Models\Article;

class ArticleController extends Controller
{
    use HasValidation;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = Article::select('id', 'name', 'alias', 'status')->paginate(12);

        return Inertia::render('Article/Index', [
            'paginate' => $paginate
        ]);
    }


    public function create()
    {
        return Inertia::render('Article/Create');
    }


    public function store(Request $request)
    {
        $validator = $this->validate($request->all());

        Article::create($validator->validated());

        return redirect()->route('articles.create')->with('success', 'Artículo creado con éxito.');
    }


    public function edit(Article $article)
    {
        return Inertia::render('Article/Edit', [
            'article' => $article
        ]);
    }


    public function update(Request $request, Article $article)
    {
        $validator = $this->validate($request->all(), $article->id);

        if ($validator->fails()) {
            return redirect()->route('articles.edit', $article)->withErrors($validator)->withInput();
        }

        $article->update($validator->validated());

        return redirect()->route('articles.edit', $article)->with('success', 'Artículo actualizado con éxito.');
    }

    public function bulkDestroy(Request $request)
    {
        Article::destroy($request->ids);
        return redirect()->route('articles.index')->with('success', 'Articles deleted successfully.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully');
    }
}
