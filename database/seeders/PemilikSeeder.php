<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PemilikSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pemilik')->insert([
            'nama' => 'Chandra Hermawan',
            'pin_hash' => Hash::make('825941'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
