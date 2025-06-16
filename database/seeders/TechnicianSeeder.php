<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\technician;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TechnicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     Technician::create([
    //         'technician_id' => 'TECH001',
    //         'technician_Name' => 'John Doe',
    //     ]);

    //     Technician::create([
    //         'technician_id' => 'TECH002',
    //         'technician_Name' => 'Jane Smith',
    //     ]);

    //     Technician::create([
    //         'technician_id' => 'TECH003',
    //         'technician_Name' => 'Aloy Smith',
    //     ]);
    // }

     public function run()
    {
     

        // Ambil semua posisi dan buat mapping nama posisi => ID    
        $positions = Position::all()->pluck('id', 'PS_Name');

        // Data teknisi dan posisi mereka
        $technicians = [
            ['name' => 'Agus Pur', 'position' => 'Chief Engineering'],
            ['name' => 'Berton H. Sianipar', 'position' => 'Spv Engineering'],
            ['name' => 'M. Arya Wirawan', 'position' => 'Spv Engineering'],
            ['name' => 'Istifar Adi Saputra', 'position' => 'Adm Engineering'],
            ['name' => 'Naswan Nusih', 'position' => 'IT Leader'],
            ['name' => 'Deddy Syahril', 'position' => 'Technical IT'],
            ['name' => 'Lian Desman H', 'position' => 'Leader Reguler'],
            ['name' => 'Heri Andrias', 'position' => 'Teknisi Reguler'],
            ['name' => 'Asep Gunawan', 'position' => 'Teknisi Reguler'],
            ['name' => 'Hendra Saputra', 'position' => 'Teknisi Reguler'],
            ['name' => 'Firman Malau', 'position' => 'Leader Reguler'],
            ['name' => 'Beni Nugraha', 'position' => 'Teknisi Reguler'],
            ['name' => 'Alif Riqillah', 'position' => 'Teknisi Reguler'],
            ['name' => 'Alexius Siahaan', 'position' => 'Teknisi Reguler'],
            ['name' => 'Sauji', 'position' => 'Leader Sipil'],
            ['name' => 'Deni Nugraha', 'position' => 'Teknisi Sipil'],
            ['name' => 'Andri Yanto', 'position' => 'Teknisi Sipil'],
            ['name' => 'Adhika Dwi', 'position' => 'Teknisi Sipil'],
            ['name' => 'Rahmat Widianto', 'position' => 'Leader Shift A'],
            ['name' => 'Triyanto', 'position' => 'Teknisi Shift A'],
            ['name' => 'Imam Syah', 'position' => 'Teknisi Shift A'],
            ['name' => 'M. Fahri', 'position' => 'Teknisi Shift A'],
            ['name' => 'Kato Firmansyah', 'position' => 'Leader Shift B'],
            ['name' => 'Adam Robiansyah', 'position' => 'Teknisi Shift B'],
            ['name' => 'Yasirli Salam', 'position' => 'Teknisi Shift B'],
            ['name' => 'Abdul Azis (D)', 'position' => 'Teknisi Shift B'],
            ['name' => 'Lukmanul Hakim', 'position' => 'Leader Shift C'],
            ['name' => 'Abdul Azis (A)', 'position' => 'Teknisi Shift C'],
            ['name' => 'Rudi Sitompul', 'position' => 'Teknisi Shift C'],
            ['name' => 'Gatot Herifuddin', 'position' => 'Teknisi Shift C'],
            ['name' => 'M. Sougi Firdaus', 'position' => 'Leader Shift D'],
            ['name' => 'Mohamad Romli', 'position' => 'Teknisi Shift D'],
            ['name' => 'Eko Satrio', 'position' => 'Teknisi Shift D'],
            ['name' => 'Fernando Vero Punuh', 'position' => 'Teknisi Shift D'],
        ];

        // Insert ke tabel technician
        foreach ($technicians as $index => $tech) {
            $ps_id = $positions[$tech['position']] ?? null;

            if (!$ps_id) {
                throw new \Exception("Position '{$tech['position']}' not found in positions table");
            }

            Technician::create([
                'technician_id' => 'TECH' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'technician_Name' => $tech['name'],
                'PS_ID' => $ps_id,
            ]);
        }
    }

}
