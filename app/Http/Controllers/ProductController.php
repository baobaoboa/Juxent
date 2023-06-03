<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Warranty;
use App\Services\Utils\FileServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
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
    public function index(Request $request){
        $query = Product::with('warranties')->with('client')->with('softwareType')->with('productType');

        //date
        if($request->date === 'asc') {
            $query = $query->orderBy('created_at', 'asc');
        }
        if($request->date === 'desc') {
            $query = $query->orderBy('created_at', 'desc');
        }

        //product_type
        if($request->product_type){
            $product_type_id = ProductType::where('product_type', 'like', '%' .$request->product_type. '%')->first()->id;
            $query = $query->where('product_type_id', $product_type_id);
        }

        //software_type
        if($request->software_type){
            $software_type_id = ProductType::where('software_type', 'like', '%' .$request->software_type. '%')->first()->id;
            $query = $query->where('software_type_id', $software_type_id);
        }
        return response($query->get(), 200);

    }
    public function store(Request $request) {
        $fields = $request->validate([
            'client_id' => 'string|required',
            'software_type_id' => 'string|required',
            'product_type_id' => 'string|required',
            'product_purchased' => 'string|required',
            'date_delivered' => 'required|string',
            'amount_paid' => 'integer|required',
            'date_paid' => 'required|string',
            'record_status' => 'required|string',
            'warranty' => 'required|string',
            'date_of_purchase' => 'required|string',
            'starting_date_of_warranty_availed' => 'required|string',
            ]);
        $product = Product::create([
            'client_id' => $fields['client_id'],
            'software_type_id' => $fields['software_type_id'],
            'product_type_id' => $fields['product_type_id'],
            'product_purchased' => $fields['product_purchased'],
            'date_of_purchase' => $fields['date_of_purchase'],
            'date_delivered' => date('Y-m-d', strtotime($fields['date_delivered'])),
        ]);


        if(!in_array(explode(';',explode('/',explode(',', $request->official_receipt)[0])[1])[0], array('jpg','jpeg','png')) ) {
            $this->throwException('Official Receipt has invalid file type', 422);
        }
        if(!in_array(explode(';',explode('/',explode(',', $request->acknowledgement_receipt)[0])[1])[0], array('jpg','jpeg','png')) ) {
            $this->throwException('Acknowledgement Receipt has invalid file type', 422);
        }

        $filename = md5($product->id.Carbon::now()->timestamp);
        $warranty = Warranty::create([
            'product_id' => $product->id,
            'created_by' => Auth::user()->id,
            'client_id' => $fields['client_id'],
            'amount_paid' => $fields['amount_paid'],
            'date_paid' => date('Y-m-d', strtotime($fields['date_paid'])),
            'record_status' => $fields['record_status'],
            'warranty' => $fields['warranty'],
            'official_receipt' =>$this->fileService->upload($this->officialReceiptFolderName, $filename, $request->official_receipt, $product->id),
            'acknowledgement_receipt' =>$this->fileService->upload($this->acknowledgementReceiptFolderName, $filename, $request->acknowledgement_receipt, $product->id),
            'starting_date_of_warranty_availed' => date('Y-m-d', strtotime($fields['starting_date_of_warranty_availed'])),
        ]);

        return response(['product' => $product, 'warranty' => $warranty], 201);
    }
    public function search(Request $request)
    {
        $fields = $request->validate(['client_id', 'required|string']);
        if(isset($request->product_purchased)){
            return Product::where('client_id', $fields['client_id'])->where('product_purchase', 'LIKE', '%'.$request->product_purchased.'%')->get();
        }
        return "";
    }
    public function update(Request $request, $id)
    {
        $product = product::find($id);
        $product->update($request->all());
        return $product;
    }
    public function destroy($id)
    {
        $product = Product::where('id', $id)->first();
        $product->deleted_at = date('Y-m-d h:m:s', Carbon::now());
        return $product;
    }
    public function showRange(Request $request)
    {
        $fields = $request->validate([
            'from' => 'required|string',
            'to' => 'required|string',
        ]);
        $from = date('Y-m-d 00:00:00', strtotime($fields['from']));
        $to = date('Y-m-d 23:59:59', strtotime($fields['to']));
        return Product::whereBetween('created_at', [$from, $to])->orWhereBetween('created_at', [$from, $to])->with('product')->paginate(25);
    }
    public function show($id){
        return Product::where('id', $id)->with('warranties')->with('user')->with('client')->with('softwareType')->with('productType')->first();
    }
}
