<?php

namespace Modules\Products\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Products\Repositories\ProductRepository;

class ProductController extends Controller
{
    public function index()
    {
        return 'Products list';
    }


    public function show($slug, ProductRepository $repo)
    {
        $product = $repo->getBySlug($slug);

        return response()->json([
            'status' => true,
            'data' => $product,
            'message' => ''
        ], 200);
    }
}