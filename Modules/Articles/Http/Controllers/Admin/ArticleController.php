<?php

namespace Modules\Articles\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Modules\Articles\Models\Article;
use Illuminate\Support\Str;
use Modules\Images\Helpers\ImageHelper;

class ArticleController extends Controller
{
    public function index()
    {
        return Inertia::render('Modules/Articles/Admin/Index', [
            'filters' => Request::all('search', 'trashed'),
            'articles' => []
        ]);
    }

    public function create()
    {
        return Inertia::render('Modules/Articles/Admin/Create', []);
    }

    public function store()
    {
        $user = Auth::user();

        Request::validate([
            'title' => 'required',
            'description' => 'required',
            'body' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
        ]);

        $article = new Article();
        $article->title = Request::get('title');
        $article->slug = Str::slug(Request::get('title'));
        $article->description = Request::get('description');
        $article->body = Request::get('body');
        $article->user_id = $user->id;

        // Store Image
        if (Request::file('image')) {
            $image = ImageHelper::storeImageWithFixedSize(Request::file('image'), 'item', 'app/public/images/articles');
            $article->image = $image;
        }

        $article->save();

        return Redirect::route('admin.articles.index')->with('success', 'Successfully saved');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);

        return Inertia::render('Modules/Articles/Admin/Edit', [
            'article' => $article
        ]);
    }

    public function update($id)
    {
        $user = Auth::user();

        Request::validate([
            'title' => 'required',
            'description' => 'required',
            'body' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
        ]);

        $article = Article::findOrFail($id);
        $article->title = Request::get('title');
        $article->slug = Str::slug(Request::get('title'));
        $article->description = Request::get('description');
        $article->body = Request::get('body');
        $article->user_id = $user->id;

        // Store Image
        if (Request::file('image')) {
            $image = ImageHelper::storeImageWithFixedSize(Request::file('image'), 'item', 'app/public/images/articles');

            // Delete Old Image
            ImageHelper::deleteImageWithFixedSize($article->image, 'app/public/images/articles');
            $article->image = $image;
        }

        $article->save();

        return Redirect::route('admin.articles.index')->with('success', 'Successfully Updated');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return Redirect::route('admin.articles.index')->with('success', 'Successfully deleted');
    }

    public function restore($id)
    {
        $article = Article::findOrFail($id);
        $article->restore();

        return Redirect::route('admin.articles.index')->with('success', 'Successfully restored');
    }
}
