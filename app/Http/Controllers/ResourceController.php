<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Warranty;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function getRecords(Request $request) {
        if($request->input('status') == 'active'){
            return Warranty::where('record_status', 'active')->orderBy('created_at', 'desc')->with('product')->paginate(25);
        }
        return Warranty::orderBy('created_at', 'desc')->with('product')->paginate(25);
    }
    public function showRecords(Request $request, $date){
        $date = date('Y-m-d', strtotime($date));
        if($request->input('status') == 'active'){
            return Warranty::where('record_status', 'active')->orderBy('created_at', 'desc')->where('updated_at', 'LIKE', '%'.$date.'%')->with('product')->paginate(25);

        }
        return Warranty::where('updated_at', 'LIKE', '%'.$date.'%')->orderBy('created_by', 'desc')->with('product')->paginate(25);
    }
}
