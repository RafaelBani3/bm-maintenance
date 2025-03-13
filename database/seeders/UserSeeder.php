<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create User -> Roles and Permission
        $admin = User::create([
            'Fullname' => 'Rafael Bani',
            'Username' => 'Admin',
            'Password' => bcrypt('admin123'), 
            'Remember_Token' => Str::random(60), 
            'CR_DT' => now(),
        ]);
        $admin->assignRole('Admin');

        // Insert CR
        $admin = User::create([
            'Fullname' => 'Pegawai CR',
            'Username' => 'Admin CR',
            'Password' => bcrypt('admin123'), 
            'Remember_Token' => Str::random(60), 
            'CR_DT' => now(),
        ]);
        $admin->assignRole('cr');

        // Insert CR_AP
        $admin = User::create([
            'Fullname' => 'Pegawai CR_AP',
            'Username' => 'Admin CR_AP',
            'Password' => bcrypt('admin123'), 
            'Remember_Token' => Str::random(60), 
            'CR_DT' => now(),
        ]);
        $admin->assignRole('cr_ap');

            // Insert WO
        $admin = User::create([
            'Fullname' => 'Pegawai WO',
            'Username' => 'Admin WO',
            'Password' => bcrypt('admin123'), 
            'Remember_Token' => Str::random(60), 
            'CR_DT' => now(),
        ]);
        $admin->assignRole('wo');
    }
}
