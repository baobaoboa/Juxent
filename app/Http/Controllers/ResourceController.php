<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function getRecords() {
        return Client::with('products')->paginate(25);
    }
}
