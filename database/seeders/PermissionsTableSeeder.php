<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        DB::table('permissions')->delete();

        Permission::firstOrCreate([
            'key'        => 'browse_admin',
            'table_name' => 'admin',
        ]);
        // return 1;
        $keys = [
            // 'browse_admin',
            'browse_bread',
            'browse_database',
            'browse_media',
            'browse_compass',
            'browse_clear-cache',
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => null,
            ]);
        }

        Permission::generateFor('menus');

        Permission::generateFor('roles');

        Permission::generateFor('users');

        Permission::generateFor('settings');


        Permission::generateFor('people');//para las personas

        Permission::generateFor('categories');
        Permission::generateFor('articles');
        Permission::generateFor('categories_facilities');
        Permission::generateFor('categories_rooms');
        Permission::generateFor('parts_hotels');
        Permission::generateFor('food');
        Permission::generateFor('food_menus');


        $keys = [
            'browse_sales',
            'add_sales',
            'print_sales',
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => 'salesProducto',
            ]);
        }




        $keys = [
            'browse_report-saleproductserviceroom',
            'browse_report-salefoodserviceroom',
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => 'reports',
            ]);
        }

        // Permission::generateFor('categories_workers');



        
    }
}
