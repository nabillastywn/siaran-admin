<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'username' => 'siaran',
            'name' => 'Siaran Admin',
            'email' => 'siaran@gmail.com',
            'password' => bcrypt('siaran'), // Menggunakan bcrypt untuk enkripsi password
            'address' => '123 Admin St',
            'phone_number' => '1234567890',
            'role' => 0,
        ]);

        // User PIC
        User::create([
            'username' => 'user_pic',
            'name' => 'User PIC',
            'email' => 'userpic@example.com',
            'password' => bcrypt('password'), // Menggunakan bcrypt untuk enkripsi password
            'address' => '456 PIC Ave',
            'phone_number' => '1234567890',
            'role' => 1,
        ]);

        // User Mahasiswa
        User::create([
            'username' => 'user_mhs',
            'name' => 'User Mahasiswa',
            'email' => 'usermhs@example.com',
            'password' => bcrypt('password'), // Menggunakan bcrypt untuk enkripsi password
            'address' => '789 Mahasiswa Blvd',
            'phone_number' => '0987654321',
            'nim' => '123456789',
            'class' => 'A',
            'major' => 'Informatics',
            'study_program' => 'S1',
            'role' => 2,
        ]);
    }
}