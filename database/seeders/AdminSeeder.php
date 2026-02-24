<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'super@gmail.com';
        $plainPassword = Str::random(8); // generate random password

        Customer::create([
            'name' => 'Super Admin',
            'email' => $email,
            'role' => 0,
            'password' => Hash::make($plainPassword), // hashed in DB
        ]);

        $this->command->info('Admin Created Successfully ✅');
        $this->command->info('Email: ' . $email);
        $this->command->info('Password: ' . $plainPassword);
    }
}
