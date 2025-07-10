<?php

namespace Database\Seeders;

use App\Models\Cats;
use App\Models\Subcats;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'New Installation',
            'Repair',
            'Licenses',
            'Contract'
        ];

        $catIds = []; 

        // foreach ($categories as $category) {
        //     $cat = Cats::create(['Cat_Name' => $category]);
        //     $catIds[$category] = $cat->Cat_No; 
        // }
        foreach ($categories as $category) {
            $cat = Cats::create([
                'Cat_No' => Cats::getIncrementCatNo(), // ✅ Pastikan ini juga dipakai
                'Cat_Name' => $category
            ]);
            $catIds[$category] = $cat->Cat_No;
        }


        $subcategories = [
            ['Cat_Name' => 'New Installation', 'Scat_Name' => 'Mechanical', 'Scat_Desc' => 'Repair and diagnostics for computers'],
            ['Cat_Name' => 'New Installation', 'Scat_Name' => 'Electrical', 'Scat_Desc' => 'Routine check and servicing of printers'],
            ['Cat_Name' => 'New Installation', 'Scat_Name' => 'HVAC', 'Scat_Desc' => 'Routine check and servicing of printers'],
            ['Cat_Name' => 'New Installation', 'Scat_Name' => 'Plumbing', 'Scat_Desc' => 'Routine check and servicing of printers'],
            ['Cat_Name' => 'Repair', 'Scat_Name' => 'Mechanical', 'Scat_Desc' => 'Operating system security and feature updates'],
            ['Cat_Name' => 'Repair', 'Scat_Name' => 'Electrical', 'Scat_Desc' => 'Security patches and bug fixes for applications'],
            ['Cat_Name' => 'Licenses', 'Scat_Name' => 'HRGA', 'Scat_Desc' => 'Security patches and bug fixes for applications'],
            ['Cat_Name' => 'Contract', 'Scat_Name' => 'HRGA', 'Scat_Desc' => 'Security patches and bug fixes for applications'],
        ];

        foreach ($subcategories as $sub) {
            Subcats::create([
                'Scat_No' => Subcats::getIncrementScatNoGlobal(), 
                'Cat_No' => $catIds[$sub['Cat_Name']], 
                'Scat_Name' => $sub['Scat_Name'],
                'Scat_Desc' => $sub['Scat_Desc'],
            ]);
        }
    }
}
