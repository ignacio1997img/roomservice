<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => 'site.title',
                'display_name' => 'Título del sitio',
                'value' => 'Título del sitio',
                'details' => '',
                'type' => 'text',
                'order' => 1,
                'group' => 'Site',
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'site.description',
                'display_name' => 'Descripción del sitio',
                'value' => 'Descripción del sitio',
                'details' => '',
                'type' => 'text',
                'order' => 2,
                'group' => 'Site',
            ),
            2 => 
            array (
                'id' => 3,
                'key' => 'site.logo',
                'display_name' => 'Logo del sitio',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 3,
                'group' => 'Site',
            ),
            3 => 
            array (
                'id' => 4,
                'key' => 'site.google_analytics_tracking_id',
                'display_name' => 'ID de rastreo de Google Analytics',
                'value' => NULL,
                'details' => '',
                'type' => 'text',
                'order' => 4,
                'group' => 'Site',
            ),
            4 => 
            array (
                'id' => 5,
                'key' => 'admin.bg_image',
                'display_name' => 'Imagen de fondo del administrador',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 5,
                'group' => 'Admin',
            ),
            5 => 
            array (
                'id' => 6,
                'key' => 'admin.title',
                'display_name' => 'Título del administrador',
                'value' => 'HOTEL',
                'details' => '',
                'type' => 'text',
                'order' => 1,
                'group' => 'Admin',
            ),
            6 => 
            array (
                'id' => 7,
                'key' => 'admin.description',
                'display_name' => 'Descripción del administrador',
                'value' => 'Sistema de Hoteleria',
                'details' => '',
                'type' => 'text',
                'order' => 2,
                'group' => 'Admin',
            ),
            7 => 
            array (
                'id' => 8,
                'key' => 'admin.loader',
                'display_name' => 'Imagen de carga del administrador',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 3,
                'group' => 'Admin',
            ),
            8 => 
            array (
                'id' => 9,
                'key' => 'admin.icon_image',
                'display_name' => 'Ícono del administrador',
                'value' => 'settings/March2023/mEgaTMZwA1aUmFVZqhn8.png',
                'details' => '',
                'type' => 'image',
                'order' => 4,
                'group' => 'Admin',
            ),
            9 => 
            array (
                'id' => 11,
                'key' => 'admin.Whatsapp',
                'display_name' => 'Mensage',
                'value' => 'Hotel Tarope%0ALa contraseña del WIFI es HT2022., Que tenga un buen día',
                'details' => NULL,
                'type' => 'text',
                'order' => 6,
                'group' => 'Admin',
            ),
            10 => 
            array (
                'id' => 12,
                'key' => 'configuracion.nrolicencia',
                'display_name' => 'Nro de Licencia de Funcionamiento',
                'value' => '324523453245',
                'details' => NULL,
                'type' => 'text',
                'order' => 2,
                'group' => 'Configuración',
            ),
            11 => 
            array (
                'id' => 13,
                'key' => 'configuracion.name',
                'display_name' => 'Nombre del Hotel
',
                'value' => 'HOTEL TAROPE',
                'details' => NULL,
                'type' => 'text',
                'order' => 1,
                'group' => 'Configuración',
            ),
            12 => 
            array (
                'id' => 14,
                'key' => 'configuracion.phone',
                'display_name' => 'Teléfono',
                'value' => '532543245',
                'details' => NULL,
                'type' => 'text',
                'order' => 3,
                'group' => 'Configuración',
            ),
            13 => 
            array (
                'id' => 15,
                'key' => 'configuracion.cellphone',
                'display_name' => 'Celular',
                'value' => NULL,
                'details' => NULL,
                'type' => 'text',
                'order' => 4,
                'group' => 'Configuración',
            ),
            14 => 
            array (
                'id' => 16,
                'key' => 'configuracion.address',
                'display_name' => 'Dirección',
                'value' => 'Calle LA Paz',
                'details' => NULL,
                'type' => 'text',
                'order' => 5,
                'group' => 'Configuración',
            ),
        ));
        
        
    }
}