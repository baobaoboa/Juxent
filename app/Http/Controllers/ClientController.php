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

    }

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
        return response([ 'client' => $client,'client_contact' => $clientContact], 201);
    }

    public function show($id)
    {
        return Client::where('id', $id)->with('contact')->first();
    }

    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
    public function search(Request $request)
    {
        if(isset($request->client_name)){
            return Client::where('client_name', 'LIKE', '%'.$request->client_name.'%')->with('contact')->get();
        }
        return "";
    }
}
