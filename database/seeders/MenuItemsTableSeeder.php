<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MenuItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menu_items')->delete();
        
        \DB::table('menu_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'menu_id' => 1,
                'title' => 'Inicio',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-house',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 1,
                'created_at' => '2023-03-17 14:13:54',
                'updated_at' => '2023-03-17 14:51:34',
                'route' => 'voyager.dashboard',
                'parameters' => 'null',
            ),
            1 => 
            array (
                'id' => 2,
                'menu_id' => 1,
                'title' => 'Media',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-images',
                'color' => NULL,
                'parent_id' => 5,
                'order' => 5,
                'created_at' => '2023-03-17 14:13:54',
                'updated_at' => '2023-03-17 14:52:13',
                'route' => 'voyager.media.index',
                'parameters' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'menu_id' => 1,
                'title' => 'Users',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-person',
                'color' => NULL,
                'parent_id' => 14,
                'order' => 1,
                'created_at' => '2023-03-17 14:13:54',
                'updated_at' => '2023-03-17 14:42:58',
                'route' => 'voyager.users.index',
                'parameters' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'menu_id' => 1,
                'title' => 'Roles',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-lock',
                'color' => NULL,
                'parent_id' => 14,
                'order' => 2,
                'created_at' => '2023-03-17 14:13:54',
                'updated_at' => '2023-03-17 14:43:01',
                'route' => 'voyager.roles.index',
                'parameters' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'menu_id' => 1,
                'title' => 'Herramientas',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-tools',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 8,
                'created_at' => '2023-03-17 14:13:54',
                'updated_at' => '2023-03-19 04:08:51',
                'route' => NULL,
                'parameters' => '',
            ),
            5 => 
            array (
                'id' => 6,
                'menu_id' => 1,
                'title' => 'Menu Builder',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-list',
                'color' => NULL,
                'parent_id' => 5,
                'order' => 1,
                'created_at' => '2023-03-17 14:13:54',
                'updated_at' => '2023-03-17 14:42:51',
                'route' => 'voyager.menus.index',
                'parameters' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'menu_id' => 1,
                'title' => 'Database',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-data',
                'color' => NULL,
                'parent_id' => 5,
                'order' => 2,
                'created_at' => '2023-03-17 14:13:54',
                'updated_at' => '2023-03-17 14:52:13',
                'route' => 'voyager.database.index',
                'parameters' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'menu_id' => 1,
                'title' => 'Compass',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-compass',
                'color' => NULL,
                'parent_id' => 5,
                'order' => 3,
                'created_at' => '2023-03-17 14:13:54',
                'updated_at' => '2023-03-17 14:52:13',
                'route' => 'voyager.compass.index',
                'parameters' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'menu_id' => 1,
                'title' => 'BREAD',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-bread',
                'color' => NULL,
                'parent_id' => 5,
                'order' => 4,
                'created_at' => '2023-03-17 14:13:54',
                'updated_at' => '2023-03-17 14:52:13',
                'route' => 'voyager.bread.index',
                'parameters' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'menu_id' => 1,
                'title' => 'Configuración',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-settings',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 9,
                'created_at' => '2023-03-17 14:13:54',
                'updated_at' => '2023-03-19 04:08:51',
                'route' => 'voyager.settings.index',
                'parameters' => 'null',
            ),
            10 => 
            array (
                'id' => 14,
                'menu_id' => 1,
                'title' => 'Seguridad',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-lock',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 7,
                'created_at' => '2023-03-17 14:42:41',
                'updated_at' => '2023-03-19 04:08:51',
                'route' => NULL,
                'parameters' => '',
            ),
            11 => 
            array (
                'id' => 15,
                'menu_id' => 1,
                'title' => 'Limpiar Cache',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-broom',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 10,
                'created_at' => '2023-03-17 14:47:14',
                'updated_at' => '2023-03-19 04:08:51',
                'route' => 'clear.cache',
                'parameters' => NULL,
            ),
            12 => 
            array (
                'id' => 16,
                'menu_id' => 1,
                'title' => 'Personas',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-people',
                'color' => NULL,
                'parent_id' => NULL,
                'order' => 2,
                'created_at' => '2023-03-17 16:33:00',
                'updated_at' => '2023-03-17 18:07:55',
                'route' => 'voyager.people.index',
                'parameters' => NULL,
            ),
            13 => 
            array (
                'id' => 17,
                'menu_id' => 1,
                'title' => 'Parametros',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-params',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 6,
                'created_at' => '2023-03-17 19:23:00',
                'updated_at' => '2023-03-19 04:08:51',
                'route' => NULL,
                'parameters' => '',
            ),
            14 => 
            array (
                'id' => 18,
                'menu_id' => 1,
                'title' => 'Categorias de Articulos',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-categories',
                'color' => NULL,
                'parent_id' => 21,
                'order' => 4,
                'created_at' => '2023-03-17 19:46:13',
                'updated_at' => '2023-03-19 05:02:27',
                'route' => 'voyager.categories.index',
                'parameters' => NULL,
            ),
            15 => 
            array (
                'id' => 20,
                'menu_id' => 1,
                'title' => 'Articulos',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-tag',
                'color' => NULL,
                'parent_id' => 21,
                'order' => 3,
                'created_at' => '2023-03-18 00:40:55',
                'updated_at' => '2023-03-20 04:35:53',
                'route' => 'voyager.articles.index',
                'parameters' => NULL,
            ),
            16 => 
            array (
                'id' => 21,
                'menu_id' => 1,
                'title' => 'Almacen',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-store',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 4,
                'created_at' => '2023-03-18 00:58:11',
                'updated_at' => '2023-03-19 03:37:58',
                'route' => NULL,
                'parameters' => '',
            ),
            17 => 
            array (
                'id' => 22,
                'menu_id' => 1,
                'title' => 'Ingreso',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-sharp fa-solid fa-cart-shopping',
                'color' => '#000000',
                'parent_id' => 21,
                'order' => 1,
                'created_at' => '2023-03-18 01:13:08',
                'updated_at' => '2023-03-18 01:19:17',
                'route' => 'incomes.index',
                'parameters' => 'null',
            ),
            18 => 
            array (
                'id' => 23,
                'menu_id' => 1,
                'title' => 'Trabajadores',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-person-digging',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 3,
                'created_at' => '2023-03-19 03:34:23',
                'updated_at' => '2023-03-19 03:37:58',
                'route' => NULL,
                'parameters' => '',
            ),
            19 => 
            array (
                'id' => 24,
                'menu_id' => 1,
                'title' => 'Personal',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-person',
                'color' => '#000000',
                'parent_id' => 23,
                'order' => 1,
                'created_at' => '2023-03-19 03:37:48',
                'updated_at' => '2023-03-19 03:37:53',
                'route' => 'worker.index',
                'parameters' => NULL,
            ),
            20 => 
            array (
                'id' => 25,
                'menu_id' => 1,
                'title' => 'Categorías de Personales',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-categories',
                'color' => NULL,
                'parent_id' => 23,
                'order' => 2,
                'created_at' => '2023-03-19 03:49:02',
                'updated_at' => '2023-03-19 03:49:38',
                'route' => 'voyager.categories-workers.index',
                'parameters' => NULL,
            ),
            21 => 
            array (
                'id' => 26,
                'menu_id' => 1,
                'title' => 'Plantas de Hotel',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-puzzle-piece',
                'color' => '#000000',
                'parent_id' => 27,
                'order' => 1,
                'created_at' => '2023-03-19 04:04:50',
                'updated_at' => '2023-03-19 04:11:10',
                'route' => 'voyager.categories-facilities.index',
                'parameters' => 'null',
            ),
            22 => 
            array (
                'id' => 27,
                'menu_id' => 1,
                'title' => 'Estructura Hotel',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-hotel',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 5,
                'created_at' => '2023-03-19 04:08:32',
                'updated_at' => '2023-03-19 04:08:51',
                'route' => NULL,
                'parameters' => '',
            ),
            23 => 
            array (
                'id' => 28,
                'menu_id' => 1,
                'title' => 'Categorías de Habitaciones',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-categories',
                'color' => NULL,
                'parent_id' => 27,
                'order' => 2,
                'created_at' => '2023-03-19 04:20:51',
                'updated_at' => '2023-03-19 04:21:25',
                'route' => 'voyager.categories-rooms.index',
                'parameters' => NULL,
            ),
            24 => 
            array (
                'id' => 29,
                'menu_id' => 1,
                'title' => 'Stock Disponible',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-brands fa-shopify',
                'color' => '#000000',
                'parent_id' => 21,
                'order' => 2,
                'created_at' => '2023-03-19 05:02:09',
                'updated_at' => '2023-03-20 04:35:53',
                'route' => 'income-article.stock',
                'parameters' => NULL,
            ),
        ));
        
        
    }
}