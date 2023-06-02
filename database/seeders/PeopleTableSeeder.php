<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PeopleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('people')->delete();
        
        \DB::table('people')->insert(array (
            0 => 
            array (
                'id' => 1,
                'ci' => '7633685',
                'first_name' => 'Ignacio',
                'last_name' => 'Molina Guzman',
                'birth_date' => '1997-03-08',
                'email' => 'ignaciomg625@hotmail.com',
                'cell_phone' => '67285914',
                'phone' => NULL,
                'address' => 'Nueva Trinidad',
                'gender' => 'masculino',
                'image' => 'people/March2023/ciCnwncuaZ698aE4JGsn.png',
                'facebook' => NULL,
                'instagram' => NULL,
                'tiktok' => NULL,
                'status' => 1,
                'created_at' => '2023-03-19 00:53:36',
                'updated_at' => '2023-03-19 00:53:36',
                'registerUser_id' => NULL,
                'deleted_at' => NULL,
                'deletedUser_id' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'ci' => '34253452345',
                'first_name' => 'Dareint',
                'last_name' => 'Peña Garcia',
                'birth_date' => '2023-03-19',
                'email' => 'darient@admin.com',
                'cell_phone' => '67662833',
                'phone' => NULL,
                'address' => 'calle la paz',
                'gender' => 'masculino',
                'image' => NULL,
                'facebook' => NULL,
                'instagram' => NULL,
                'tiktok' => NULL,
                'status' => 1,
                'created_at' => '2023-03-19 00:54:21',
                'updated_at' => '2023-05-23 15:15:40',
                'registerUser_id' => NULL,
                'deleted_at' => NULL,
                'deletedUser_id' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'ci' => '1234234',
                'first_name' => 'juan',
                'last_name' => 'CRUZ CRUZ',
                'birth_date' => '2023-03-22',
                'email' => NULL,
                'cell_phone' => '68989989',
                'phone' => NULL,
                'address' => 'dfsdfsd',
                'gender' => 'masculino',
                'image' => NULL,
                'facebook' => NULL,
                'instagram' => NULL,
                'tiktok' => NULL,
                'status' => 1,
                'created_at' => '2023-03-22 08:39:07',
                'updated_at' => '2023-03-22 08:39:07',
                'registerUser_id' => NULL,
                'deleted_at' => NULL,
                'deletedUser_id' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'ci' => '12345678',
                'first_name' => 'pedro',
                'last_name' => 'jismene',
                'birth_date' => '2023-03-28',
                'email' => NULL,
                'cell_phone' => '7589666',
                'phone' => NULL,
                'address' => NULL,
                'gender' => 'masculino',
                'image' => NULL,
                'facebook' => NULL,
                'instagram' => NULL,
                'tiktok' => NULL,
                'status' => 1,
                'created_at' => '2023-03-28 06:11:58',
                'updated_at' => '2023-03-28 06:11:58',
                'registerUser_id' => NULL,
                'deleted_at' => NULL,
                'deletedUser_id' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'ci' => '785444',
                'first_name' => 'Maria Eugenia',
                'last_name' => 'Malue',
                'birth_date' => '1996-04-12',
                'email' => NULL,
                'cell_phone' => NULL,
                'phone' => NULL,
                'address' => NULL,
                'gender' => 'femenino',
                'image' => NULL,
                'facebook' => NULL,
                'instagram' => NULL,
                'tiktok' => NULL,
                'status' => 1,
                'created_at' => '2023-04-02 17:42:58',
                'updated_at' => '2023-04-02 17:42:58',
                'registerUser_id' => NULL,
                'deleted_at' => NULL,
                'deletedUser_id' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'ci' => '162551',
                'first_name' => 'Nogales',
                'last_name' => 'Armez',
                'birth_date' => '2023-05-09',
                'email' => NULL,
                'cell_phone' => '70261086',
                'phone' => NULL,
                'address' => 'Vacaa',
                'gender' => 'masculino',
                'image' => NULL,
                'facebook' => NULL,
                'instagram' => NULL,
                'tiktok' => NULL,
                'status' => 1,
                'created_at' => '2023-05-23 15:18:29',
                'updated_at' => '2023-05-23 15:18:29',
                'registerUser_id' => NULL,
                'deleted_at' => NULL,
                'deletedUser_id' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'ci' => '61515',
                'first_name' => 'silverio',
                'last_name' => 'mamani',
                'birth_date' => '1968-06-21',
                'email' => NULL,
                'cell_phone' => '69373572',
                'phone' => NULL,
                'address' => 'central',
                'gender' => 'masculino',
                'image' => 'people/May2023/7io9JY9GhyWJP2yiVfAp.jpg',
                'facebook' => NULL,
                'instagram' => NULL,
                'tiktok' => NULL,
                'status' => 1,
                'created_at' => '2023-05-23 15:36:53',
                'updated_at' => '2023-05-23 16:35:06',
                'registerUser_id' => NULL,
                'deleted_at' => NULL,
                'deletedUser_id' => NULL,
            ),
        ));
        
        
    }
}