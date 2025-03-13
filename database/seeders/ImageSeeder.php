<?php

namespace Database\Seeders;

use App\Models\Imgs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Imgs::create([
            'IMG_Type'     => 'WO',
            'IMG_RefNo'    => 'REF001',
            'IMG_Filename' => 'gambar1.png',
            'IMG_Realname' => 'produk1.png',
        ]);

        Imgs::create([
            'IMG_Type'     => 'BA',
            'IMG_RefNo'    => 'REF002',
            'IMG_Filename' => 'file1.pdf',
            'IMG_Realname' => 'invoice1.pdf',
        ]);

        Imgs::create([
            'IMG_Type'     => 'WO',
            'IMG_RefNo'    => 'REF003',
            'IMG_Filename' => 'gambar2.png',
            'IMG_Realname' => 'produk2.png',
        ]);
    }
}
