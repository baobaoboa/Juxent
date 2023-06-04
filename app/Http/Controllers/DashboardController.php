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
        $result = [];
        $product = Product::all()
            ->groupBy('client_id')
            ->map(function ($product) {
                return $product->count();
            });
        $result['Highest'] = $product->max();
        $result['Lowest'] = $product->min();
        return response( $result, 200);
    }

    public function totalClientRecordsByMonth($year) {
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June', 'July',
            'August', 'September', 'October', 'November', 'December'
        ];

        $data = Product::selectRaw('MONTH(date_of_purchase) as month, COUNT(*) as count')
            ->whereYear('date_of_purchase', $year)
            ->groupBy('month')
            ->get();

        $result = array_fill_keys($months, 0);

        foreach ($data as $row) {
            $monthName = date('F', mktime(0, 0, 0, $row->month, 1));
            $result[$monthName] = $row->count;
        }

        return response()->json($result);
    }
}
