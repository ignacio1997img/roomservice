<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;
use Illuminate\Support\Facades\DB;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_role')->delete();

        $role = Role::where('name', 'admin')->firstOrFail();

        $permissions = Permission::all();

        $role->permissions()->sync(
            $permissions->pluck('id')->all()
        );




        $role = Role::where('name', 'limpieza')->firstOrFail();
        $permissions = Permission::whereRaw("   table_name = 'admin' or
                                                
                                                table_name = 'plugins' or
                                                table_name = 'planillas_adicionales' or
                                                `key` = 'browse_reportscashiervaults'")->get();
        $role->permissions()->sync($permissions->pluck('id')->all());
    }
}
