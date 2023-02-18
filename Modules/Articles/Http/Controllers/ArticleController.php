<?php

namespace Modules\Articles\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Modules\Articles\Models\Article;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['user'])
            ->orderBy('id', 'DESC')
            ->filter(Request::only('search', 'trashed'))
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Modules/Articles/Site/Index', [
            'filters' => Request::all('search', 'trashed'),
            'articles' => $articles
        ]);
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('slug', $slug)
            ->first();

        return Inertia::render('Modules/Articles/Site/Show', [
            'article' => $article
        ]);
    }
}
