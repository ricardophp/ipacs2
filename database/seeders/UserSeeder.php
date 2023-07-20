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

        User::create([
            'name'=>'Marcelo Gustavo Dominguez',
            'id_paciente' =>'Marcelo',
            'email'=>'marcelosimedsalud@gmail.com',
            'password'=>bcrypt('domanegraSimed')
        ])->assignRole('Administrador');
        User::create([
            'name'=>'Administración SIMED',
            'id_paciente' =>'Administracion',
            'email'=>'simedsalud@gmail.com',
            'password'=>bcrypt('Simed#23')
        ])->assignRole('Administrador');
}
}
