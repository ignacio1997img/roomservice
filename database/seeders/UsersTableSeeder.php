<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'role_id' => 1,
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'avatar' => 'users/default.png',
                'email_verified_at' => NULL,
                'password' => '$2y$10$pq1cVKtgM2GU72ZjcFz0BemICBZfJAUW8SUOf4KhtMZ91FTiFUsPa',
                'remember_token' => 'Lq5bWHtcXqdIfCt2PX2IXMsVFrpipTKcopIyIKEEHAnkXTX3C7ZHe6YhJbyb',
                'settings' => NULL,
                'created_at' => '2023-03-17 14:14:06',
                'updated_at' => '2023-03-17 14:14:06',
            ),
        ));
        
        
    }
}