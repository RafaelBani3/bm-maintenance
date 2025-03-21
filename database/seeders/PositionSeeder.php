<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            ['PS_Name' => 'Spv Engineering', 'PS_Desc' => 'Supervisor Engineering'],
            ['PS_Name' => 'HR Admin', 'PS_Desc' => 'Human Resources Administrator'],
            ['PS_Name' => 'TR', 'PS_Desc' => 'Transport Coordinator'],
            ['PS_Name' => 'IT Leader', 'PS_Desc' => 'Information Technology Leader'],
            ['PS_Name' => 'Adm Engineering', 'PS_Desc' => 'Administration Engineering'],
            ['PS_Name' => 'Security & Parking', 'PS_Desc' => 'Security and Parking Management'],
            ['PS_Name' => 'HSE Koordinator', 'PS_Desc' => 'Health, Safety, and Environment Coordinator'],
            ['PS_Name' => 'Store Keeper', 'PS_Desc' => 'Warehouse and Inventory Management'],
            ['PS_Name' => 'Adm Engineering', 'PS_Desc' => 'Administration Engineering'],
            ['PS_Name' => 'HRGA', 'PS_Desc' => 'HRGA'],
            ['PS_Name' => 'Spv. Building Tenant Management', 'PS_Desc' => 'Spv. Building Tenant Management'],
            ['PS_Name' => 'Spv. Finance accounting', 'PS_Desc' => 'Spv. Finance accounting'],
            ['PS_Name' => 'Head Of Building Management', 'PS_Desc' => 'Head Of Building Management'],
            ['PS_Name' => 'COO', 'PS_Desc' => 'COO'],

        ];

        Position::insert($positions);
    }
}
