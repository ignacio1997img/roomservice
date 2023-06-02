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


        $keys = [
            'browse_admin',
            'browse_clear-cache'
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => 'admin'
            ]);
        }
        
        // return 1;
        $keys = [
            // 'browse_admin',
            'browse_bread',
            'browse_database',
            'browse_media',
            'browse_compass'
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => 'tools'
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
                'table_name' => 'sales_Producto',
            ]);
        }

        $keys = [
            'browse_incomes',
            'print_incomes',
            'browse_incomes-articlestock'
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => 'incomes',
            ]);
        }


        //Para la estructura del hotel
        $keys = [
            'browse_categories_rooms',
            'add_categories_rooms',
            'edit_categories_rooms',
            'read_categories_rooms',
            'delete_categories_rooms'
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => 'categories_rooms',
            ]);
        }

        $keys = [
            'browse_rooms',
            'add_rooms',
            'edit_rooms',
            'read_rooms',
            'delete_rooms'
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => 'rooms',
            ]);
        }
        

        //Para el index voyager 
        $keys = [
            'graphic',
            'add_assign',
            'read_assign',
            'add_product',
            'add_food',
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => 'services',
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
