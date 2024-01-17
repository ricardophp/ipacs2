<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /** UTILIZAO LARAVEL SPATIE PARA ROLES Y PERMISOS!
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1= Role::create(['name'=>'Administrador']);
        $role2= Role::create(['name'=>'Médicos']);
        $role3= Role::create(['name'=>'Pacientes']);
        $role4= Role::create(['name'=>'SuperAdmin']);

        $permission = Permission::create(['name' => 'dashboard'])->syncRoles([$role1,$role3]);
        $permission = Permission::create(['name' => 'estudios'])->syncRoles([$role1,$role2]);
        $permission = Permission::create(['name' => 'users'])->syncRoles([$role1,$role4]);
    }
}
