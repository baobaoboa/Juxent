<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmployeeRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Operation Manager', 'Secretary', 'Project Leader', 'Sale Consultant', 'Support'];
        for ($i=0; $i<count($roles); $i++){
            DB::table('employee_roles')->insert([
                ['role' => $roles[$i], 'slug' => str::slug($roles[$i])],
            ]);
        }
    }
}
