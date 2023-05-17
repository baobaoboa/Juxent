<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function  store(Request $request) {
        $fields = $request->validate([
            'client_id' => 'string|required',
            'software_type_id' => 'string|required',
            'product_type' => 'string|required',
            'product_purchased' => 'string|required',
            'date_delivered' => 'required|string',
            'amount_paid' => 'integer|required',
            'date_paid' => 'required|string',
            'official_receipt' => 'required|string',
            'acknowledgement_receipt' => 'required|string',
            'record_status' => 'required|string',
            'warranty' => 'required|string',
            'starting_date_of_warranty_availed' => 'required|string',
            ]);
        $product = Product::create([
            'client_id' => $fields['client_id'],
            'software_type_id' => $fields['software_type_id'],
            'product_type' => $fields['product_type'],
            'product_purchased' => $fields['product_purchased'],
            'date_delivered' => date('Y-m-d', strtotime($fields['date_delivered'])),
        ]);

        $warranty = Warranty::create([
            'product_id' => $product->id,
            'created_by' => Auth::user()->id,
            'client_id' => $fields['client_id'],
            'amount_paid' => $fields['amount_paid'],
            'date_paid' => date('Y-m-d', strtotime($fields['date_paid'])),
            'official_receipt' => $fields['official_receipt'],
            'acknowledgement_receipt' => $fields['acknowledgement_receipt'],
            'record_status' => $fields['record_status'],
            'warranty' => $fields['warranty'],
            'starting_date_of_warranty_availed' => date('Y-m-d', strtotime($fields['starting_date_of_warranty_availed'])),
        ]);
        return response(['product' => $product, 'warranty' => $warranty], 201);
    }

    public function search(Request $request)
    {
        if(isset($request->product_purchased)){
            return Product::where('client_name', 'LIKE', '%'.$request->product_purchased.'%')->get();
        }
        return "";
    }
}
