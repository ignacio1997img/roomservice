<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesRoomsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories_rooms')->delete();
        
        \DB::table('categories_rooms')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Habitaciones matrimoniales',
                'description' => 'cama matrimonial',
                'created_at' => '2023-03-19 00:44:35',
                'updated_at' => '2023-05-23 16:08:00',
                'deleted_at' => '2023-05-23 16:08:00',
                'registerUser_id' => NULL,
                'deletedUser_id' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Habitaciones Triples',
                'description' => 'para 3 personas',
                'created_at' => '2023-03-19 00:45:37',
                'updated_at' => '2023-05-23 16:04:17',
                'deleted_at' => NULL,
                'registerUser_id' => NULL,
                'deletedUser_id' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Habitaciones Dobles',
                'description' => 'para 2 personas',
                'created_at' => '2023-03-19 00:45:49',
                'updated_at' => '2023-05-23 16:03:53',
                'deleted_at' => NULL,
                'registerUser_id' => NULL,
                'deletedUser_id' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Suite',
                'description' => NULL,
                'created_at' => '2023-03-19 00:46:02',
                'updated_at' => '2023-05-23 16:09:12',
                'deleted_at' => NULL,
                'registerUser_id' => NULL,
                'deletedUser_id' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Habitacion Simple',
                'description' => 'esta habitación es para una sola persona',
                'created_at' => '2023-03-19 00:46:29',
                'updated_at' => '2023-05-23 16:03:07',
                'deleted_at' => NULL,
                'registerUser_id' => NULL,
                'deletedUser_id' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Habitaciones Cuadruple',
                'description' => 'para 4 personas',
                'created_at' => '2023-04-13 16:35:45',
                'updated_at' => '2023-05-23 16:04:54',
                'deleted_at' => NULL,
                'registerUser_id' => 1,
                'deletedUser_id' => NULL,
            ),
        ));
        
        
    }
}