<?php

namespace Database\Seeders;

use App\Models\material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            [
                'Material_No' => 'MAT001',
                'Material_Name' => 'Thermal Paste',
                'Material_Stock' => '100',
                'Material_Unit' => 'pcs',
            ],
            [
                'Material_No' => 'MAT002',
                'Material_Name' => 'SSD 512GB',
                'Material_Stock' => '25',
                'Material_Unit' => 'pcs',
            ],
            [
                'Material_No' => 'MAT003',
                'Material_Name' => 'Power Cable',
                'Material_Stock' => '75',
                'Material_Unit' => 'roll',
            ],
            [
                'Material_No' => 'MAT004',
                'Material_Name' => 'Motherboard ATX',
                'Material_Stock' => '15',
                'Material_Unit' => 'pcs',
            ],
            [
                'Material_No' => 'MAT005',
                'Material_Name' => 'SATA Cable',
                'Material_Stock' => '60',
                'Material_Unit' => 'pcs',
            ],
        ];

        foreach ($materials as $material) {
            material::create($material);
        }
    }

}
