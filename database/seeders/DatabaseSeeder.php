<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(20)->create();

        \App\Models\User::factory()->create([
            'name' => 'Fariz Satria',
            'email' => 'fariz@example.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin'
        ]);

        \App\Models\Pembimbing::factory()->create([
            'name' => 'Satria Refandino',
            'email' => 'fariz@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        //data dummy for company
        \App\Models\Company::create([
            'name' => 'PT.Lauwba Techno Indonesia',
            'email' => 'lauwba@example.com',
            'address' => 'Jl. Taman Kenari No.A3, Kledokan, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281',
            'latitude' => '-7.772990877930496',
            'longitude' => ' 110.40529262121755',
            'radius_km' => '1',
            'time_in' => '08:00',
            'time_out' => '17:00',
        ]);

        $this->call([
            AttendanceSeeder::class,
            PermissionSeeder::class
        ]);
    }
}
