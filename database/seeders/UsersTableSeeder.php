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
            ['id' => Str::uuid(),'role_id' => '1', 'first_name' => 'John', 'last_name' => 'doe', 'email' => 'johndoe@gmail.com', 'password' => bcrypt('Johndoe123')],
        ]);
    }
}
