<?php

namespace Database\Seeders;

use Illuminate\Auth\Access\Gate;
use Illuminate\Database\Seeder;
use App\Models\UserMod;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Crea los Roles
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'User']);

        //Asigna Rol a ID 1
        $user1 = UserMod::find(1);
        $user1->assignRole($role1->id);

        //Asigna Rol a ID 2
        $user2 = UserMod::find(2);
        $user2->assignRole($role2->id);
    }
}
