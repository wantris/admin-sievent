<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Admin::create([
            'nama'    => 'admin',
            'username'    => 'admin',
            'password'    => Hash::make('admin'),
            'email'    =>  'admin@admin.com',
        ]);
    }
}
