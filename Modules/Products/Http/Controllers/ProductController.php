<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Modules\Products\Http\Resources\ProductResource;
use Modules\Products\Models\Product;
use Modules\Products\Repositories\ProductRepository;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Modules/Products/Site/Index', []);
    }

    public function show($slug, ProductRepository $repo)
    {
        $product = $repo->getBySlug($slug);

        return Inertia::render('Modules/Products/Site/Index', [
            'product' => new ProductResource($product)
        ]);
    }
}