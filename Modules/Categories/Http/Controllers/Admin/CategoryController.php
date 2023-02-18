<?php

namespace Modules\Categories\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Modules\Categories\Models\Category;
use Modules\Images\Helpers\ImageHelper;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Modules/Categories/Admin/Index', [
            'filters' => Request::all('search', 'trashed'),
            'categories' => []
        ]);
    }

    public function create()
    {
        return Inertia::render('Modules/Categories/Admin/Create');
    }

    public function store()
    {
        $user = Auth::user();

        Request::validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,svg'
        ]);

        $category = new Category();
        $category->title = Request::get('title');
        $category->slug = Str::slug(Request::get('title'));
        $category->description = Request::get('description');

        if (Request::file('image')) {
            $image = ImageHelper::storeImageWithFixedSize(Request::file('image'), 'category', 'app/public/images/categories');
            $category->image = $image;
        }

        $category->save();

        return Redirect::route('admin.categories.index')->with('success', 'Successfully Saved');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return Inertia::render('Modules/Categories/Admin/Edit', [
            'category' => $category
        ]);
    }

    public function update($id)
    {
        $user = Auth::user();

        Request::validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,svg'
        ]);

        $category = Category::findOrFail($id);

        $category->title = Request::get('title');
        $category->slug = Str::slug(Request::get('title'));
        $category->description = Request::get('description');

        if (Request::file('image')) {
            $image = ImageHelper::storeImageWithFixedSize(Request::file('image'), 'category', 'app/public/images/categories');

            // Delete Old Image
            ImageHelper::deleteImageWithFixedSize($category->image, 'app/public/images/categories');

            $category->image = $image;
        }

        $category->save();

        return Redirect::route('admin.categories.index')->with('success', 'Successfully Updated');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        
        return Redirect::route('admin.categories.index')->with('success', 'Successfully deleted.');
    }

    public function restore($id)
    {
        $category = Category::findOrFail($id);
        $category->restore();

        return Redirect::back()->with('success', 'Restored Successfully.');
    }
}
