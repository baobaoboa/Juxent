<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function getRecords() {
        return Client::with('contact')->with('products')->paginate(25);
    }
}
