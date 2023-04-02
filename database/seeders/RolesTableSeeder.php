<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $role = Role::firstOrNew(['name' => 'admin']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.admin'),
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'administrador']);
        if (!$role->exists) {
            $role->fill(['display_name' => 'Administrador'])->save();
        }

        $role = Role::firstOrNew(['name' => 'gerente']);
        if (!$role->exists) {
            $role->fill(['display_name' => 'Gerente'])->save();
        }

        $role = Role::firstOrNew(['name' => 'recepcionista']);
        if (!$role->exists) {
            $role->fill(['display_name' => 'Recepcionistas'])->save();
        }

        $role = Role::firstOrNew(['name' => 'limpieza']);
        if (!$role->exists) {
            $role->fill(['display_name' => 'Limpieza'])->save();
        }

        $role = Role::firstOrNew(['name' => 'cocina']);
        if (!$role->exists) {
            $role->fill(['display_name' => 'Cocina'])->save();
        }

        $role = Role::firstOrNew(['name' => 'reporte']);
        if (!$role->exists) {
            $role->fill(['display_name' => 'Reporte'])->save();
        }
    }
}
