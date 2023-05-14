<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function  store(Request $request) {
        $fields = $request->validate([
            'client_id' => 'string|required',
            'software_type_id' => 'string|required',
            'product_type' => 'string|required',
            'product_status' => 'string|required',
            'product_purchased' => 'string|required',
            'date_delivered' => 'required|string',
            ]);
        $product = Product::create([
            'client_id' => $fields['client_id'],
            'software_type_id' => $fields['software_type_id'],
            'product_type' => $fields['product_type'],
            'product_status' => $fields['product_status'],
            'product_purchased' => $fields['product_purchased'],
            'date_delivered' => date('Y-m-d', strtotime($fields['date_delivered'])),
        ]);
        return response($product, 201);
    }
}
