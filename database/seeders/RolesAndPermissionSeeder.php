<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

         // create permissions
         Permission::create(['name' => 'Modifier']);
         Permission::create(['name' => 'Suprimer']);
         Permission::create(['name' => 'Voir']);
         Permission::create(['name' => 'Mettre à jour']);

         // create roles and assign created permissions

         // this can be done as separate statements
         $role = Role::create(['name' => 'Employé']);
         $role->givePermissionTo('Voir');

         // or may be done by chaining
         $role = Role::create(['name' => 'Technicien'])
             ->givePermissionTo(['Modifier', 'Mettre à jour']);

         $role = Role::create(['name' => 'super-admin']);
         $role->givePermissionTo(Permission::all());
    }
}
