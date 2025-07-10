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
                ['PS_Name' => 'Spv Engineering', 'PS_Desc' => 'Supervisor Engineering', 'dept_no' => 'DEPT001'],
                ['PS_Name' => 'HR Admin', 'PS_Desc' => 'Human Resources Administrator', 'dept_no' => 'DEPT009'],
                ['PS_Name' => 'TR', 'PS_Desc' => 'Transport Coordinator', 'dept_no' => 'DEPT007'],
                ['PS_Name' => 'IT Leader', 'PS_Desc' => 'Information Technology Leader', 'dept_no' => 'DEPT001'],
                ['PS_Name' => 'Adm Engineering', 'PS_Desc' => 'Administration Engineering', 'dept_no' => 'DEPT001'],
                ['PS_Name' => 'Security & Parking', 'PS_Desc' => 'Security and Parking Management', 'dept_no' => 'DEPT005'],
                ['PS_Name' => 'HSE Koordinator', 'PS_Desc' => 'Health, Safety, and Environment Coordinator', 'dept_no' => 'DEPT008'],
                ['PS_Name' => 'Store Keeper', 'PS_Desc' => 'Warehouse and Inventory Management', 'dept_no' => 'DEPT009'],
                ['PS_Name' => 'HRGA', 'PS_Desc' => 'HRGA', 'dept_no' => 'DEPT009'],
                ['PS_Name' => 'Spv. Building Tenant Management', 'PS_Desc' => 'Spv. Building Tenant Management', 'dept_no' => 'DEPT007'],
                ['PS_Name' => 'Spv. Finance accounting', 'PS_Desc' => 'Spv. Finance accounting', 'dept_no' => 'DEPT002'],
                ['PS_Name' => 'Head Of Building Management', 'PS_Desc' => 'Head Of Building Management', 'dept_no' => 'DEPT001'],
                ['PS_Name' => 'COO', 'PS_Desc' => 'COO', 'dept_no' => 'DEPT001'],
                ['PS_Name' => 'Creator', 'PS_Desc' => 'Creator', 'dept_no' => 'DEPT001'],
                ['PS_Name' => 'Approver', 'PS_Desc' => 'Approver', 'dept_no' => 'DEPT002'],

                ['PS_Name' => 'Chief Engineering', 'PS_Desc' => 'Chief Engineering', 'dept_no' => 'DEPT001'],
                ['PS_Name' => 'Technical IT', 'PS_Desc' => 'Technical IT', 'dept_no' => 'DEPT001'],
                ['PS_Name' => 'Leader Reguler', 'PS_Desc' => 'Leader Reguler', 'dept_no' => null],
                ['PS_Name' => 'Teknisi Reguler', 'PS_Desc' => 'Teknisi Reguler', 'dept_no' => null],
                ['PS_Name' => 'Leader Sipil', 'PS_Desc' => 'Leader Sipil', 'dept_no' => null],
                ['PS_Name' => 'Teknisi Sipil', 'PS_Desc' => 'Teknisi Sipil', 'dept_no' => null],
                ['PS_Name' => 'Leader Shift A', 'PS_Desc' => 'Leader Shift A', 'dept_no' => null],
                ['PS_Name' => 'Teknisi Shift A', 'PS_Desc' => 'Teknisi Shift A', 'dept_no' => null],
                ['PS_Name' => 'Leader Shift B', 'PS_Desc' => 'Leader Shift B', 'dept_no' => null],
                ['PS_Name' => 'Teknisi Shift B', 'PS_Desc' => 'Teknisi Shift B', 'dept_no' => null],
                ['PS_Name' => 'Leader Shift C', 'PS_Desc' => 'Leader Shift C', 'dept_no' => null],
                ['PS_Name' => 'Teknisi Shift C', 'PS_Desc' => 'Teknisi Shift C', 'dept_no' => null],
                ['PS_Name' => 'Leader Shift D', 'PS_Desc' => 'Leader Shift D', 'dept_no' => null],
                ['PS_Name' => 'Teknisi Shift D', 'PS_Desc' => 'Teknisi Shift D', 'dept_no' => null],
            ];


            Position::insert($positions);
    }
}

