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
        $types = ['Software','Hardware','Miscellaneous','Others'];
        for($i=0; $i<count($types); $i++){
            DB::table('product_types')->insert([
                'product_type' => $types[$i]
            ]);
        }
    }
}
