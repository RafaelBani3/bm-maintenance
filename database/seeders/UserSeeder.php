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
        $user1 = User::create([
            'Fullname' => 'Moh Arya Wirawan',
            'Username' => 'Arya',
            'Password' => bcrypt('admin123'),
            'Remember_Token' => Str::random(60),
            'PS_ID' => '1',
            'CR_DT' => now(),
        ]);
        $user1->assignRole( 'cr', 'cr_ap','wo','wo_ap');

        $user2 = User::create([
            'Fullname' => 'Berton H Sianipar',
            'Username' => 'Berton',
            'Password' => bcrypt('admin123'),
            'Remember_Token' => Str::random(60),
            'PS_ID' => '1',
            'CR_DT' => now(),
        ]);
        $user2->assignRole('cr','wo');

        $user3 = User::create([
            'Fullname' => 'Aisyah Nuraini',
            'Username' => 'Aisyah',
            'Password' => bcrypt('admin123'),
            'Remember_Token' => Str::random(60),
            'PS_ID' => '2',
            'CR_DT' => now(),
        ]);
        $user3->assignRole('cr', 'mr','wo');

        $user4 = User::create([
            'Fullname' => 'Cece Bayu Muttaqin',
            'Username' => 'Cece',
            'Password' => bcrypt('admin123'),
            'Remember_Token' => Str::random(60),
            'PS_ID' => '3', 
            'CR_DT' => now(),
        ]);
        $user4->assignRole('cr', 'mr', 'wo');

        $user5 = User::create([
            'Fullname' => 'Puti Amelia',
            'Username' => 'Puti',
            'Password' => bcrypt('admin123'),
            'Remember_Token' => Str::random(60),
            'PS_ID' => '3',
            'CR_DT' => now(),
        ]);
        $user5->assignRole('cr', 'mr', 'wo');

        $user6 = User::create([
            'Fullname' => 'Naswan Nusih',
            'Username' => 'Naswan',
            'Password' => bcrypt('admin123'),
            'Remember_Token' => Str::random(60),
            'PS_ID' => '4', 
            'CR_DT' => now(),
        ]);
        $user6->assignRole('cr', 'wo');

        $user7 = User::create([
            'Fullname' => 'Istifar Adi Saputra',
            'Username' => 'Adi Saputra',
            'Password' => bcrypt('admin123'),
            'Remember_Token' => Str::random(60),
            'PS_ID' => '5', 
            'CR_DT' => now(),
        ]);
        $user7->assignRole('cr', 'mr', 'wo');

        $user8 = User::create([
            'Fullname' => 'Abdul Haris',
            'Username' => 'Abdul',
            'Password' => bcrypt('admin123'),
            'Remember_Token' => Str::random(60),
            'PS_ID' => '6', 
            'CR_DT' => now(),
        ]);
        $user8->assignRole('cr','wo');

        
        $user9 = User::create([
            'Fullname' => 'Tri Rizki Febrianti',
            'Username' => 'Rizki',
            'Password' => bcrypt('admin123'),
            'Remember_Token' => Str::random(60),
            'PS_ID' => '7', 
            'CR_DT' => now(),
        ]);
        $user9->assignRole('cr', 'wo');

        
        $user10 = User::create([
            'Fullname' => 'Rizqhan Fajar Pramudita',
            'Username' => 'Rizqhan',
            'Password' => bcrypt('admin123'),
            'Remember_Token' => Str::random(60),
            'PS_ID' => '8', 
            'CR_DT' => now(),
        ]);
        $user10->assignRole('cr', 'mr', 'mr_ap', 'wo');

        
        $user11 = User::create([
            'Fullname' => 'Agus Purnomo',
            'Username' => 'Agus',
            'Password' => bcrypt('admin123'),
            'Remember_Token' => Str::random(60),
            'PS_ID' => '9',
            'CR_DT' => now(),
        ]);
        $user11->assignRole('cr_ap', 'mr_ap');

        
        $user12 = User::create([
            'Fullname' => 'Ahmad Habibi',
            'Username' => 'Ahmad',
            'Password' => bcrypt('admin123'),
            'Remember_Token' => Str::random(60),
            'PS_ID' => '10',
            'CR_DT' => now(),
        ]);
<<<<<<< HEAD
        $user12->assignRole('cr_ap','mr_ap');
=======
        $user12->assignRole('cr_ap','mr_ap','wo_ap');
>>>>>>> ff25b43 (Update)

        
        $user13 = User::create([
            'Fullname' => 'Herda Simbolon',
            'Username' => 'Herda',
            'Password' => bcrypt('admin123'),
            'Remember_Token' => Str::random(60),
            'PS_ID' => '11', 
            'CR_DT' => now(),
        ]);
        $user13->assignRole('cr_ap');


        $user14 = User::create([
            'Fullname' => 'Valentina Ria',
            'Username' => 'Valentina',
            'Password' => bcrypt('admin123'),
            'Remember_Token' => Str::random(60),
            'PS_ID' => '12', 
            'CR_DT' => now(),
        ]);
        $user14->assignRole('cr_ap');   

        $user15 = User::create([
            'Fullname' => 'Meidiono Triandoko',
            'Username' => 'Meidiono',
            'Password' => bcrypt('admin123'),
            'Remember_Token' => Str::random(60),
            'PS_ID' => '13  ', 
            'CR_DT' => now(),
        ]);
        $user15->assignRole('cr_ap', 'mr_ap');  

        
        $user16 = User::create([
            'Fullname' => 'Margiman',
            'Username' => 'Margiman',
            'Password' => bcrypt('admin123'),
            'Remember_Token' => Str::random(60),
            'PS_ID' => '14  ', 
            'CR_DT' => now(),
        ]);
        $user16->assignRole('mr_ap');  

        

    //     //Create User -> Roles and Permission
    //     $admin = User::create([
    //         'Fullname' => 'Rafael Bani',
    //         'Username' => 'Admin',
    //         'Password' => bcrypt('admin123'), 
    //         'Remember_Token' => Str::random(60), 
    //         'PS_ID' => '1',
    //         'CR_DT' => now(),
    //     ]);
    //     $admin->assignRole('Admin');

    //     // Insert CR
    //     $cr = User::create([
    //         'Fullname' => 'Pegawai CR',
    //         'Username' => 'Admin CR',
    //         'Password' => bcrypt('admin123'), 
    //         'Remember_Token' => Str::random(60), 
    //         'PS_ID' => '2',
    //         'CR_DT' => now(),
    //     ]);
    //     $cr->assignRole('cr');

    //     // Insert CR_AP
    //     $cr_ap1 = User::create([
    //         'Fullname' => 'Moh Arya',
    //         'Username' => 'Arya CR_AP',
    //         'Password' => bcrypt('admin123'), 
    //         'Remember_Token' => Str::random(60), 
    //         'PS_ID' => '3',
    //         'CR_DT' => now(),
    //     ]);
    //     $cr_ap1->assignRole('cr_ap');

    //     // Insert CR_AP
    //     $cr_ap2 = User::create([
    //         'Fullname' => 'Agus',
    //         'Username' => 'Agus CR_AP',
    //         'Password' => bcrypt('admin123'), 
    //         'Remember_Token' => Str::random(60), 
    //         'PS_ID' => '3',
    //         'CR_DT' => now(),
    //     ]);
    //     $cr_ap2->assignRole('cr_ap');

    //           // Insert CR_AP
    //     $cr_ap3 = User::create([
    //         'Fullname' => 'Meidiono',
    //         'Username' => 'Meidiono CR_AP',
    //         'Password' => bcrypt('admin123'), 
    //         'Remember_Token' => Str::random(60), 
    //         'PS_ID' => '3',
    //         'CR_DT' => now(),
    //     ]);
    //     $cr_ap3->assignRole('cr_ap');
        
    //     $cr_ap4 = User::create(attributes: [
    //         'Fullname' => 'Herda',
    //         'Username' => 'Herda CR_AP',
    //         'Password' => bcrypt(value: 'admin123'), 
    //         'Remember_Token' => Str::random(60), 
    //         'PS_ID' => '3',
    //         'CR_DT' => now(),
    //     ]);
    //     $cr_ap4->assignRole('cr_ap');

    //     $cr_ap5 = User::create(attributes: [
    //         'Fullname' => 'Ahmad',
    //         'Username' => 'Ahmad CR_AP',
    //         'Password' => bcrypt(value: 'admin123'), 
    //         'Remember_Token' => Str::random(60), 
    //         'PS_ID' => '3',
    //         'CR_DT' => now(),
    //     ]);
    //     $cr_ap5->assignRole('cr_ap');
        
        
    //     $cr_ap6 = User::create(attributes: [
    //         'Fullname' => 'Valentina',
    //         'Username' => 'Valentina CR_AP',
    //         'Password' => bcrypt(value: 'admin123'), 
    //         'Remember_Token' => Str::random(60), 
    //         'PS_ID' => '3',
    //         'CR_DT' => now(),
    //     ]);
    //     $cr_ap6->assignRole('cr_ap');

        
    //     $cr_ap7 = User::create(attributes: [
    //         'Fullname' => 'Rizqhan',
    //         'Username' => 'Rizqhan CR_AP',
    //         'Password' => bcrypt(value: 'admin123'), 
    //         'Remember_Token' => Str::random(60), 
    //         'PS_ID' => '3',
    //         'CR_DT' => now(),
    //     ]);
    //     $cr_ap7->assignRole('cr_ap');

    //     $cr_ap7 = User::create(attributes: [
    //         'Fullname' => 'Rizqhan',
    //         'Username' => 'Rizqhan CR_AP',
    //         'Password' => bcrypt(value: 'admin123'), 
    //         'Remember_Token' => Str::random(60), 
    //         'PS_ID' => '3',
    //         'CR_DT' => now(),
    //     ]);
    //     $cr_ap7->assignRole('cr_ap');
        
    //     // Insert WO
    //     $wo = User::create([
    //         'Fullname' => 'Pegawai WO',
    //         'Username' => 'Admin WO',
    //         'Password' => bcrypt('admin123'), 
    //         'Remember_Token' => Str::random(60), 
    //         'CR_DT' => now(),
    //         'PS_ID' => '4',
    //     ]);
    //     $wo->assignRole('wo');
    }
}
