<?php

namespace Modules\Products\Repositories;

use Modules\PaymentMethods\Models\PaymentMethod;
use Modules\Products\Models\Product;

class ProductRepository
{
    public function all()
    {
    }

    public function getBySlug($slug)
    {
        $item = Product::with(['items'])->where('slug', $slug)
            ->first();

        $payment_methods = PaymentMethod::where('status', 1)
            ->get();

        $item->payment_methods = $payment_methods;

        return $item;
    }
}
