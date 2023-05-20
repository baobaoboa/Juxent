<?php

namespace App\Http\Controllers;

use App\Models\Warranty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarrantyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 1;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'product_id' => 'string|required',
            'client_id' => 'string|required',
            'amount_paid' => 'integer|required',
            'date_paid' => 'required|string',
            'official_receipt' => 'required|string',
            'acknowledgement_receipt' => 'required|string',
            'record_status' => 'required|string',
            'warranty' => 'required|string',
            'starting_date_of_warranty_availed' => 'required|string',
        ]);
        $warranty = Warranty::create([
            'product_id' => $fields['product_id'],
            'created_by' => Auth::user()->id,
            'amount_paid' => $fields['amount_paid'],
            'date_paid' => date('Y-m-d', strtotime($fields['date_paid'])),
            'official_receipt' => $fields['official_receipt'],
            'acknowledgement_receipt' => $fields['acknowledgement_receipt'],
            'record_status' => $fields['record_status'],
            'warranty' => $fields['warranty'],
            'starting_date_of_warranty_availed' => date('Y-m-d', strtotime($fields['starting_date_of_warranty_availed'])),
        ]);

        return response($warranty, 201);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
