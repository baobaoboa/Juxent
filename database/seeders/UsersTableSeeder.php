<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['id' => Str::uuid(),'role_id' => '1', 'first_name' => 'Lorenz Jedd', 'last_name' => 'Alvarez', 'email' => 'lorenzjeddalvarez@juxent.com', 'password' => bcrypt('Password@123')],
            ['id' => Str::uuid(),'role_id' => '2', 'first_name' => 'Maria Camille', 'last_name' => 'Reyes', 'email' => 'mariacamillereyes@juxent.com', 'password' => bcrypt('Password@123')],
            ['id' => Str::uuid(),'role_id' => '3', 'first_name' => 'Alodia Shane', 'last_name' => 'Puralan', 'email' => 'alodiashanepuralan@juxent.com', 'password' => bcrypt('Password@123')],
            ['id' => Str::uuid(),'role_id' => '4', 'first_name' => 'Earlene Jan', 'last_name' => 'Mosquera', 'email' => 'earlenejanmosquera@juxent.com', 'password' => bcrypt('Password@123')],
            ['id' => Str::uuid(),'role_id' => '5', 'first_name' => 'Neil Gabriel', 'last_name' => 'Tadea', 'email' => 'neilgabrieltadea@juxent.com', 'password' => bcrypt('Password@123')],
        ]);
    }
}
