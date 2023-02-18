<?php

namespace Modules\PopularProducts\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Modules\PopularProducts\Models\PopularProduct;
use Modules\Products\Models\Product;

class PopularProductController extends Controller
{
    public function index()
    {
        $popular_product_Ids = PopularProduct::pluck('product_id')->toArray();
        $popular_products = Product::whereIn('id', $popular_product_Ids)
            ->get();

        $products = Product::where('status', 1)
            ->whereNotIn('id', $popular_product_Ids)
            ->orderBy('created_at', 'DESC')
            ->get();

        return Inertia::render('Modules/PopularProducts/Admin/Index', [
            'filters' => Request::all('search', 'trashed'),
            'popular_products' => $popular_products,
            'products' => $products,
        ]);
    }

    public function create()
    {
        $products = Product::where('status', 1)
            ->get();

        return Inertia::render('Modules/PopularProducts/Admin/Create', [
            'products' => $products
        ]);
    }

    public function store()
    {
        Request::validate([
            'product_id' => 'required'
        ]);

        $item = new PopularProduct();
        $item->product_id = Request::get('product_id');
        $item->save();

        return Redirect()->route('admin.popular-products.index')->with('success', 'Successfully added');
    }

    public function edit($id)
    {
        $product = PopularProduct::with(['product'])->findOrFail($id);

        return Inertia::render('Modules/PopularProducts/Admin/Edit', [
            'product' => $product
        ]);
    }

    public function update($id)
    {
        Request::validate([
            'product_id' => 'required'
        ]);

        $item = PopularProduct::findOrFail($id);
        $item->product_id = Request::get('product_id');
        $item->save();

        return Redirect()->route('admin.popular-products.index')->with('success', 'Successfully updated');
    }

    public function destroy($id)
    {
        $item = PopularProduct::findOrFail($id);
        $item->delete();

        return Redirect()->route('admin.popular-products.index')->with('success', 'Successfully deleted');
    }

    public function restore($id)
    {
        $item = PopularProduct::findOrFail($id);
        $item->restore();

        return Redirect()->route('admin.popular-products.index')->with('success', 'Successfully restored');
    }
}
