<?php

namespace Database\Seeders;

use App\Models\Departement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $departments = [
            ['dept_name' => 'Engineering',    'dept_desc' => 'Tim Engineering',        'dept_code' => 'ENG'],
            ['dept_name' => 'Finance',        'dept_desc' => 'Tim Keuangan',           'dept_code' => 'FA'],
            ['dept_name' => 'IT',             'dept_desc' => 'Teknologi Informasi',    'dept_code' => 'IT'],
            ['dept_name' => 'Housekeeping',   'dept_desc' => 'Kebersihan Gedung',      'dept_code' => 'HKP'],
            ['dept_name' => 'Security',       'dept_desc' => 'Tim Pengamanan',         'dept_code' => 'SEC'],
            ['dept_name' => 'Fitout',         'dept_desc' => 'Fitout',                 'dept_code' => 'FIT'],
            ['dept_name' => 'TR',             'dept_desc' => 'TR',                     'dept_code' => 'TR'],
            ['dept_name' => 'HSE',            'dept_desc' => 'HSE',                    'dept_code' => 'HSE'],
            ['dept_name' => 'HR',             'dept_desc' => 'Human Resource',         'dept_code' => 'HR'],
        ];

        foreach ($departments as $dept) {
            Departement::create([
                'dept_no'   => Departement::generateDeptNo(),
                'dept_name' => $dept['dept_name'],
                'dept_desc' => $dept['dept_desc'],
                'dept_code' => strtoupper($dept['dept_code']),
            ]);
        }
    }
}
