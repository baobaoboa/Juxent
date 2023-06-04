<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SoftwareType;
use App\Models\Warranty;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function totalClientRecords($year){

        $software_types = SoftwareType::all()->pluck('software_type');
        $result = SoftwareType::all()->pluck('software_type')->mapWithKeys(function ($item) {
            return [$item => 0];
        });
        for($i=0;$i<count($software_types); $i++){
            $id = SoftwareType::where('software_type', $software_types[$i])->first()->id;
            $result[$software_types[$i]] = Product::where('software_type_id', $id)->count();
        }
        return  $result;
    }

    public function totalWarrantyRecords() {
        $now = Carbon::now()->subYear();
        $result = [];
        $result['inactive'] = 0;
        $result['active'] = Warranty::where('starting_date_of_warranty_availed', '>=', $now)->get()->groupBy('product_id')->count();
        $result['expired']= Warranty::where('starting_date_of_warranty_availed', '<', $now)->get()->groupBy('product_id')->count();
        Warranty::where('starting_date_of_warranty_availed', '>=', $now)
            ->get()
            ->groupBy('product_id')
            ->map(function ($warranties) use (&$result) {
                $inactiveCount = $warranties->count() - 1;
                $result['inactive'] += $inactiveCount;
                return $inactiveCount;
            });
        return response($result, 200);
    }
    public function purchasedByClient() {

    }
}
