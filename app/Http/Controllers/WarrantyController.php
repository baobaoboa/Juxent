<?php

namespace App\Http\Controllers;

use App\Models\Warranty;
use App\Services\Utils\FileServiceInterface;
use App\Traits\ExceptionTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarrantyController extends Controller
{

    use ExceptionTrait;
    private $fileService;
    private $officialReceiptFolderName;
    private $acknowledgementReceiptFolderName;

    public function __construct(FileServiceInterface $fileService)
    {

        $this->fileService = $fileService;
        $this->officialReceiptFolderName = config('storage.base_path') . 'official_receipt';
        $this->acknowledgementReceiptFolderName = config('storage.base_path') . 'acknowledgement_receipt';
    }
    public function index(Request $request)
    {
        $query = Warranty::with('product');

        //date
        if($request->date === 'asc') {
            $query = $query->orderBy('created_at', 'asc');
        }
        if($request->date === 'desc') {
            $query = $query->orderBy('created_at', 'desc');
        }

        if(isset($request->from)){
            if(isset($request->to)){
                $from = date('Y-m-d 00:00:00', strtotime($request->from));
                $to = date('Y-m-d 23:59:59', strtotime($request->to));
                return Warranty::whereBetween('created_at', [$from, $to])->orWhereBetween('created_at', [$from, $to])->with('product')->paginate(25);

            }
            else {
                $this->throwException('Date To is required', 400);
            }
        }

        //record_status
        if($request->record_status){
            $query = $query->where('record_status', $request->record_status);
        }
        return response($query->get(), 200);
    }


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

    public function show($date)
    {

    }

    public function update(Request $request, $id)
    {
        $warranty = Warranty::find($id);
        $warranty->update($request->all());
        return $warranty;
    }
    public function destroy($id)
    {
        $warranty = warranty::where('id', $id)->first();
        $warranty->deleted_at = date('Y-m-d h:m:s', Carbon::now());
        return $warranty;
    }
    public function showRange(Request $request)
    {
        $fields = $request->validate([
            'from' => 'required|string',
            'to' => 'required|string',
        ]);
        $from = date('Y-m-d 00:00:00', strtotime($fields['from']));
        $to = date('Y-m-d 23:59:59', strtotime($fields['to']));
        return Warranty::whereBetween('created_at', [$from, $to])->orWhereBetween('created_at', [$from, $to])->with('product')->paginate(25);
    }
}
