<?php

namespace App\Http\Controllers;

use App\Models\Warranty;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
            'client_id' => 'string|required',
            'amount_paid' => 'integer|required',
            'date_paid' => 'required|string',
            'official_receipt' => 'required|string',
            'acknowledgement_receipt' => 'required|string',
            'record_status' => 'required|string',
        ]);
        $warranty = Warranty::create([
            'client_id' => $fields['client_id'],
            'amount_paid' => $fields['amount_paid'],
            'date_paid' => date('Y-m-d', strtotime($fields['date_paid'])),
            'official_receipt' => $fields['official_receipt'],
            'acknowledgement_receipt' => $fields['acknowledgement_receipt'],
            'record_status' => $fields['record_status'],
        ]);

        return response($warranty, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
