<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Ricardo Alejandro Godoy',
            'id_paciente' =>'23691396',
            'email'=>'ricardo.norbit@gmail.com',
            'password'=>bcrypt('19740224')
        ])->assignRole('Administrador');
}
}
