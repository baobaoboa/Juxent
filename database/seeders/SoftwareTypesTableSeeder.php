<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SoftwareTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['Retail','Fast Food Restaurant','Fine Dining','Supermarket','Pharmacy'];
        for($i=0; $i<count($types); $i++){
            DB::table('software_types')->insert([
                'software_types' => $types[$i]
            ]);
        }
    }
}
