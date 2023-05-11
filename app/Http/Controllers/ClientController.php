<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Traits\ExceptionTrait;
use Illuminate\Http\Request;

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
        //
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
