<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
           'name' => 'test3',
           'email' => 'test@test.com',
           'email_verified_at' => Carbon::now(),
           'password' => bcrypt('testtest'),
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
       ]);
    }
}
