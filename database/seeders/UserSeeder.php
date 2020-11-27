<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(){

       User::create([
            'name' => 'kunal bhatti',
            'email' => 'kunal.bhatti15@gmail.com',
            'password' => Hash::make('kunal12'),
            'role' => 'admin'
        ]);

    }
}
