<?php

namespace Modules\Products\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Modules\Categories\Models\Category;
use Modules\Images\Helpers\ImageHelper;
use Modules\Products\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Modules/Products/Admin/Index', [
            'filters' => Request::all('search', 'trashed'),
        ]);
    }

    public function show($id)
    {
        $product = Product::with('items')->findOrFail($id);

        return Inertia::render('Modules/Products/Admin/Show', [
            'product' => $product
        ]);
    }

    public function create()
    {
        $categories = Category::get();

        return Inertia::render('Modules/Products/Admin/Create', [
            'categories' => $categories
        ]);
    }

    public function store()
    {
        $user = Auth::user();

        Request::validate([
            'title' => 'required',
            'description' => 'nullable',
            'image' => 'required|image|mimes:png,jpg,jpeg,svg',
            'cover_image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
            'body' => 'nullable',
            'discount' => 'nullable',
            'is_need_game_user' => 'nullable',
            'is_need_server' => 'nullable',
            'status' => 'nullable',
            'category_id' => 'required'
        ]);

        $product = new Product();
        $product->user_id = $user->id;
        $product->title = Request::get('title');
        $product->slug = Str::slug(Request::get('title'));
        $product->description = Request::get('description');

        // Store Image and Cover Image
        if (Request::file('image')) {
            $image = ImageHelper::storeImageWithDifferentSizes(Request::file('image'), 'product', 'app/public/images/products');
            $product->image = $image;
        }

        if (Request::file('cover_image')) {
            $cover_image = ImageHelper::storeImageWithFixedSize(Request::file('cover_image'), 'product-cover', 'app/public/images/products/covers');
            $product->cover_image = $cover_image;
        }

        $product->body = Request::get('body');
        $product->discount = Request::get('discount') ?? 0.0;
        $product->category_id = Request::get('category_id');
        $product->is_need_game_user = Request::get('is_need_game_user') ?? 1;
        $product->is_need_server = Request::get('is_need_server') ?? 1;
        $product->save();

        return Redirect()->route('admin.products.index')->with('success', 'Successfully saved');
    }

    public function edit($id)
    {
        $product = Product::with(['items'])->findOrFail($id);
        $categories = Category::get();

        return Inertia::render('Modules/Products/Admin/Edit', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    public function update($id)
    {
        $user = Auth::user();

        Request::validate([
            'title' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
            'cover_image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
            'body' => 'nullable',
            'discount' => 'nullable',
            'is_need_game_user' => 'nullable',
            'is_need_server' => 'nullable',
            'status' => 'nullable',
            'category_id' => 'required'
        ]);

        $product = Product::findOrFail($id);

        // Store Image and Cover Image, delete old images
        if (Request::file('image')) {
            $image = ImageHelper::storeImageWithDifferentSizes(Request::file('image'), 'product', 'app/public/images/products');

            ImageHelper::deleteImageWithDifferentSizes($product->image, 'app/public/images/products');
            $product->image = $image;
        }

        if (Request::file('cover_image')) {
            $cover_image = ImageHelper::storeImageWithFixedSize(Request::file('cover_image'), 'product-cover', 'app/public/images/products/covers');

            ImageHelper::deleteImageWithFixedSize($product->cover_image, 'app/public/images/products/covers');
            $product->image = $image;
        }

        $product->user_id = $user->id;
        $product->title = Request::get('title');
        $product->slug = Str::slug(Request::get('title'));
        $product->description = Request::get('description');
        $product->image = $image;
        $product->cover_image = $cover_image;
        $product->body = Request::get('body');
        $product->discount = Request::get('discount') ?? 0.0;
        $product->category_id = Request::get('category_id');
        $product->is_need_game_user = Request::get('is_need_game_user') ?? 1;
        $product->is_need_server = Request::get('is_need_server') ?? 1;
        $product->save();

        return Redirect()->route('admin.products.index')->with('success', 'Successfully updated');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return Redirect::back()->with('success', 'Successfully deleted');
    }

    public function restore($id)
    {
        $product = Product::findOrFail($id);

        $product->restore();
        return Redirect::back()->with('success', 'Successfully restored.');
    }
}
