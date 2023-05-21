<?php

namespace App\Http\Controllers;

use App\Models\Warranty;
use App\Services\Utils\FileServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarrantyController extends Controller
{
    private $fileService;
    private $officialReceiptFolderName;
    private $acknowledgementReceiptFolderName;

    public function __construct(FileServiceInterface $fileService)
    {

        $this->fileService = $fileService;
        $this->officialReceiptFolderName = config('storage.base_path') . 'official_receipt';
        $this->acknowledgementReceiptFolderName = config('storage.base_path') . 'acknowledgement_receipt';
    }
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

        if(!in_array(explode(';',explode('/',explode(',', $request->official_receipt)[0])[1])[0], array('jpg','jpeg','png')) ) {
            $this->throwException('Official Receipt has invalid file type', 422);
        }
        if(!in_array(explode(';',explode('/',explode(',', $request->acknowledgement_receipt)[0])[1])[0], array('jpg','jpeg','png')) ) {
            $this->throwException('Acknowledgement Receipt has invalid file type', 422);
        }

        $filename = md5($fields['product_id'].Carbon::now()->timestamp);
        $warranty = Warranty::create([
            'product_id' => $fields['product_id'],
            'created_by' => Auth::user()->id,
            'client_id' => $fields['client_id'],
            'amount_paid' => $fields['amount_paid'],
            'date_paid' => date('Y-m-d', strtotime($fields['date_paid'])),
            'record_status' => $fields['record_status'],
            'warranty' => $fields['warranty'],
            'official_receipt' =>$this->fileService->upload($this->officialReceiptFolderName, $filename, $request->official_receipt, $fields['product_id']),
            'acknowledgement_receipt' =>$this->fileService->upload($this->acknowledgementReceiptFolderName, $filename, $request->acknowledgement_receipt, $fields['product_id']),
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
