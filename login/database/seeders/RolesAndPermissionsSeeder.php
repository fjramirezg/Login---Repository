<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserMod; // Importa el modelo correcto
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Resetear cache de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos generales
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        // Añade más permisos según tus necesidades

        // Crear rol de Super Admin
        $superAdminRole = Role::create(['name' => 'super-admin']);

        // Asignar todos los permisos al Super Admin
        $superAdminRole->givePermissionTo(Permission::all());

        // Asignar rol de super-admin a un usuario específico
        $user = UserMod::where('email', 'superadmin@tuapp.com')->first();

        if ($user) {
            $user->assignRole('super-admin');
        } else {
            $this->command->error('Usuario con email superadmin@tuapp.com no encontrado.');
        }
    }
}
