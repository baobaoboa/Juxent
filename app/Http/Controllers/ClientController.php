<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientContact;
use App\Models\Product;
use App\Models\Warranty;
use App\Traits\ExceptionTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{

    use ExceptionTrait;
    public function index(Request $request)
    {

        //select client->where yung latest warranty niya is equal sa request->date.
        if(isset($request->date)){
            $client = Client::where('created_at', $request->date)->join();
        }
        return Client::all();
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
            'first_name' => 'string|required',
            'middle_name' => '',
            'last_name' => 'string|required',
            'email' => 'string|required',
            'contact_number' => 'string|required',
            'client_name' => 'string|required',
            'company_address' => 'string|required',
            'software_type_id' => 'string|required',
            'product_type' => 'string|required',
            'product_status' => 'string|required',
            'product_purchased' => 'string|required',
            'amount_paid' => 'integer|required',
            'date_paid' => 'required|string',
            'official_receipt' => 'required|string',
            'acknowledgement_receipt' => 'required|string',
            'date_delivered' => 'required|string',
            'record_status' => 'required|string',
        ]);

        $clientContact = ClientContact::create([
            'first_name' => $fields['first_name'],
            'middle_name' => $fields['middle_name'],
            'last_name' => $fields['last_name'],
            'email' => $fields['email'],
            'contact_number' => $fields['contact_number'],
        ]);

        $client = Client::create([
            'created_by' => Auth::user()->id,
            'client_name' => $fields['client_name'],
            'company_address' => $fields['company_address'],
            'contact_id' => $clientContact->id,
        ]);
        $product = Product::create([
            'client_id' => $client->id,
            'software_type_id' => $fields['software_type_id'],
            'product_type' => $fields['product_type'],
            'product_status' => $fields['product_status'],
            'product_purchased' => $fields['product_purchased'],
        ]);
        $warranty = Warranty::create([

            'client_id' => $client->id,
            'date_of_purchase' => Carbon::now(),
            'amount_paid' => $fields['amount_paid'],
            'date_paid' => date('Y-m-d', strtotime($fields['date_paid'])),
            'official_receipt' => $fields['official_receipt'],
            'acknowledgement_receipt' => $fields['acknowledgement_receipt'],
            'date_delivered' => date('Y-m-d', strtotime($fields['date_delivered'])),
            'record_status' => $fields['record_status'],
        ]);
        return response([ 'client' => $client,'client_contact' => $clientContact, 'product' => $product, 'warranty' => $warranty], 201);
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
