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
        return Client::whereNull('deleted_at')->paginate(25);
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
        $client = Client::find($id);
        $client->update($request->except(['first_name', 'middle_name', 'last_name', 'email', 'contact_number']));
        if(isset($request->first_name) || isset($request->middle_name) || isset($request->last_name) || isset($request->contact_number) || isset($request->email)){
            $client_contact = ClientContact::find($id);
            $client_contact->update($request->except(['created_by', 'client_name', 'company_address', 'contact_id']));
        }
        return $client;
    }
    public function destroy($id)
    {
        $client = Client::where('id', $id)->first();
        $client->deleted_at = date('Y-m-d h:m:s', Carbon::now());
        return $client;
    }
    public function search(Request $request)
    {
        if(isset($request->client_name)){
            return Client::where('client_name', 'LIKE', '%'.$request->client_name.'%')->with('contact')->get();
        }
        return "";
    }
}
