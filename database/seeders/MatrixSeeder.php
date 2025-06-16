<?php

namespace Database\Seeders;

use App\Models\Matrix;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatrixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $matrices = [
                ['Mat_No' => 1, 'Position' => 1, 'Mat_Type' => 'CR', 'Mat_Max' => 2 ,'AP1' => 11, 'AP2' => 15],
                ['Mat_No' => 2, 'Position' => 2, 'Mat_Type' => 'CR', 'Mat_Max' => 2 ,'AP1' => 12, 'AP2' => 15],
                ['Mat_No' => 3, 'Position' => 3, 'Mat_Type' => 'CR', 'Mat_Max' => 2 ,'AP1' => 13, 'AP2' => 15],
                ['Mat_No' => 4, 'Position' => 4, 'Mat_Type' => 'CR', 'Mat_Max' => 2 ,'AP1' => 1, 'AP2' => 11],
                ['Mat_No' => 5, 'Position' => 5, 'Mat_Type' => 'CR', 'Mat_Max' => 2 ,'AP1' => 1, 'AP2' => 11],
                ['Mat_No' => 6, 'Position' => 6, 'Mat_Type' => 'CR', 'Mat_Max' => 2 ,'AP1' => 1, 'AP2' => 11],
                ['Mat_No' => 7, 'Position' => 7, 'Mat_Type' => 'CR', 'Mat_Max' => 2 ,'AP1' => 1, 'AP2' => 11],
                ['Mat_No' => 8, 'Position' => 8, 'Mat_Type' => 'CR', 'Mat_Max' => 2 ,'AP1' => 14, 'AP2' => 15],
                ['Mat_No' => 9, 'Position' => 5, 'Mat_Type' => 'MR', 'Mat_Max' => 4 ,'AP1' => 10, 'AP2' => 12, 'AP3' => 15, 'AP4' => 16],
                ['Mat_No' => 10, 'Position' => 3, 'Mat_Type' => 'MR', 'Mat_Max' => 4 ,'AP1' => 10, 'AP2' => 12, 'AP3' => 15, 'AP4' => 16],
                ['Mat_No' => 11, 'Position' => 8, 'Mat_Type' => 'MR', 'Mat_Max' => 4 ,'AP1' => 10, 'AP2' => 12, 'AP3' => 15, 'AP4' => 16],
                ['Mat_No' => 12, 'Position' => 2, 'Mat_Type' => 'MR', 'Mat_Max' => 4 ,'AP1' => 10, 'AP2' => 12, 'AP3' => 15, 'AP4' => 16],
            ];
    
            foreach ($matrices as $matrix) {
                Matrix::create($matrix);
            }
        }
    }

