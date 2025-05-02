<?php

namespace Database\Seeders;

use App\Models\technician;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Technician::create([
            'technician_id' => 'TECH001',
            'technician_Name' => 'John Doe',
        ]);

        Technician::create([
            'technician_id' => 'TECH002',
            'technician_Name' => 'Jane Smith',
        ]);

        Technician::create([
            'technician_id' => 'TECH003',
            'technician_Name' => 'Aloy Smith',
        ]);
    }

}
