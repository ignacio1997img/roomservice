<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesFacilitiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories_facilities')->delete();
        
        \DB::table('categories_facilities')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Planta Baja',
                'description' => 'plata baja cuenta con 8 habitaciones',
                'created_at' => '2023-03-19 00:46:53',
                'updated_at' => '2023-05-23 15:58:19',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Planta 1',
                'description' => 'Primer Piso hay 16 habitaciones',
                'created_at' => '2023-03-19 00:47:15',
                'updated_at' => '2023-05-23 16:00:26',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Planta 2',
                'description' => 'Existen 12 habitaciones',
                'created_at' => '2023-03-23 07:36:09',
                'updated_at' => '2023-06-01 14:11:59',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Planta 3',
                'description' => 'hay 2 habitaciones',
                'created_at' => '2023-05-23 16:01:32',
                'updated_at' => '2023-06-01 14:11:33',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}