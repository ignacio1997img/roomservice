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
                'created_at' => '2023-03-16 14:13:54',
                'updated_at' => '2023-03-16 14:51:34',
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
                'created_at' => '2023-03-16 14:13:54',
                'updated_at' => '2023-03-16 14:52:13',
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
                'created_at' => '2023-03-16 14:13:54',
                'updated_at' => '2023-03-16 14:42:58',
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
                'created_at' => '2023-03-16 14:13:54',
                'updated_at' => '2023-03-16 14:43:01',
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
                'order' => 13,
                'created_at' => '2023-03-16 14:13:54',
                'updated_at' => '2023-07-12 22:20:27',
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
                'created_at' => '2023-03-16 14:13:54',
                'updated_at' => '2023-03-16 14:42:51',
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
                'created_at' => '2023-03-16 14:13:54',
                'updated_at' => '2023-03-16 14:52:13',
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
                'created_at' => '2023-03-16 14:13:54',
                'updated_at' => '2023-03-16 14:52:13',
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
                'created_at' => '2023-03-16 14:13:54',
                'updated_at' => '2023-03-16 14:52:13',
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
                'order' => 14,
                'created_at' => '2023-03-16 14:13:54',
                'updated_at' => '2023-07-12 22:20:27',
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
                'order' => 12,
                'created_at' => '2023-03-16 14:42:41',
                'updated_at' => '2023-07-12 22:20:27',
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
                'order' => 15,
                'created_at' => '2023-03-16 14:47:14',
                'updated_at' => '2023-07-12 22:20:27',
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
                'order' => 3,
                'created_at' => '2023-03-16 16:33:00',
                'updated_at' => '2023-07-12 22:20:27',
                'route' => 'voyager.people.index',
                'parameters' => NULL,
            ),
            13 => 
            array (
                'id' => 18,
                'menu_id' => 1,
                'title' => 'Categorias de Articulos',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-categories',
                'color' => NULL,
                'parent_id' => 40,
                'order' => 2,
                'created_at' => '2023-03-16 19:46:13',
                'updated_at' => '2023-07-05 07:44:03',
                'route' => 'voyager.categories.index',
                'parameters' => NULL,
            ),
            14 => 
            array (
                'id' => 20,
                'menu_id' => 1,
                'title' => 'Articulos',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-tag',
                'color' => NULL,
                'parent_id' => 40,
                'order' => 1,
                'created_at' => '2023-03-17 00:40:55',
                'updated_at' => '2023-07-05 07:44:03',
                'route' => 'voyager.articles.index',
                'parameters' => NULL,
            ),
            15 => 
            array (
                'id' => 21,
                'menu_id' => 1,
                'title' => 'Almacen',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-store',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 8,
                'created_at' => '2023-03-17 00:58:11',
                'updated_at' => '2023-07-12 22:20:27',
                'route' => NULL,
                'parameters' => '',
            ),
            16 => 
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
                'created_at' => '2023-03-17 01:13:08',
                'updated_at' => '2023-03-17 01:19:17',
                'route' => 'incomes.index',
                'parameters' => 'null',
            ),
            17 => 
            array (
                'id' => 23,
                'menu_id' => 1,
                'title' => 'Trabajadores',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-person-digging',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 7,
                'created_at' => '2023-03-18 03:34:23',
                'updated_at' => '2023-07-12 22:20:27',
                'route' => NULL,
                'parameters' => '',
            ),
            18 => 
            array (
                'id' => 26,
                'menu_id' => 1,
                'title' => 'Plantas de Hotel',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-puzzle-piece',
                'color' => '#000000',
                'parent_id' => 27,
                'order' => 3,
                'created_at' => '2023-03-18 04:04:50',
                'updated_at' => '2023-03-20 00:34:10',
                'route' => 'voyager.categories-facilities.index',
                'parameters' => 'null',
            ),
            19 => 
            array (
                'id' => 27,
                'menu_id' => 1,
                'title' => 'Estructura Hotel',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-hotel',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 10,
                'created_at' => '2023-03-18 04:08:32',
                'updated_at' => '2023-07-12 22:20:27',
                'route' => NULL,
                'parameters' => '',
            ),
            20 => 
            array (
                'id' => 28,
                'menu_id' => 1,
                'title' => 'Categorías',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-categories',
                'color' => '#000000',
                'parent_id' => 27,
                'order' => 2,
                'created_at' => '2023-03-18 04:20:51',
                'updated_at' => '2023-03-21 12:45:49',
                'route' => 'voyager.categories-rooms.index',
                'parameters' => 'null',
            ),
            21 => 
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
                'created_at' => '2023-03-18 05:02:09',
                'updated_at' => '2023-03-19 04:35:53',
                'route' => 'income-article.stock',
                'parameters' => NULL,
            ),
            22 => 
            array (
                'id' => 30,
                'menu_id' => 1,
                'title' => 'Accesorio',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-list',
                'color' => '#000000',
                'parent_id' => 27,
                'order' => 4,
                'created_at' => '2023-03-19 17:11:53',
                'updated_at' => '2023-03-21 12:46:22',
                'route' => 'voyager.parts-hotels.index',
                'parameters' => 'null',
            ),
            23 => 
            array (
                'id' => 31,
                'menu_id' => 1,
                'title' => 'Habitaciones',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-person-booth',
                'color' => '#000000',
                'parent_id' => 27,
                'order' => 1,
                'created_at' => '2023-03-20 00:33:57',
                'updated_at' => '2023-06-01 23:12:28',
                'route' => 'voyager.rooms.index',
                'parameters' => 'null',
            ),
            24 => 
            array (
                'id' => 32,
                'menu_id' => 1,
                'title' => 'Comidas',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-bowl-food',
                'color' => '#000000',
                'parent_id' => 33,
                'order' => 2,
                'created_at' => '2023-03-28 04:37:45',
                'updated_at' => '2023-03-28 04:52:33',
                'route' => 'voyager.food.index',
                'parameters' => 'null',
            ),
            25 => 
            array (
                'id' => 33,
                'menu_id' => 1,
                'title' => 'Comidas',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-utensils',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 6,
                'created_at' => '2023-03-28 04:41:36',
                'updated_at' => '2023-07-12 22:20:27',
                'route' => NULL,
                'parameters' => '',
            ),
            26 => 
            array (
                'id' => 34,
                'menu_id' => 1,
                'title' => 'Menú del Día',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-list',
                'color' => '#000000',
                'parent_id' => 33,
                'order' => 1,
                'created_at' => '2023-03-28 04:49:56',
                'updated_at' => '2023-03-28 04:52:32',
                'route' => 'voyager.food-menus.index',
                'parameters' => 'null',
            ),
            27 => 
            array (
                'id' => 35,
                'menu_id' => 1,
                'title' => 'Reportes',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-chart-pie',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 5,
                'created_at' => '2023-03-29 13:56:15',
                'updated_at' => '2023-07-12 22:20:27',
                'route' => NULL,
                'parameters' => '',
            ),
            28 => 
            array (
                'id' => 36,
                'menu_id' => 1,
                'title' => 'Productos Vendidos',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-print',
                'color' => '#000000',
                'parent_id' => 35,
                'order' => 1,
                'created_at' => '2023-03-29 14:23:56',
                'updated_at' => '2023-03-29 20:13:53',
                'route' => 'report.saleproductserviceroom',
                'parameters' => 'null',
            ),
            29 => 
            array (
                'id' => 37,
                'menu_id' => 1,
                'title' => 'Ventas de Productos',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-cart-shopping',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 4,
                'created_at' => '2023-03-29 14:30:39',
                'updated_at' => '2023-07-12 22:20:27',
                'route' => 'sales.index',
                'parameters' => NULL,
            ),
            30 => 
            array (
                'id' => 38,
                'menu_id' => 1,
                'title' => 'Ventas De Comida',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-print',
                'color' => '#000000',
                'parent_id' => 35,
                'order' => 2,
                'created_at' => '2023-03-29 20:40:10',
                'updated_at' => '2023-03-29 20:40:31',
                'route' => 'report.salefoodserviceroom',
                'parameters' => NULL,
            ),
            31 => 
            array (
                'id' => 39,
                'menu_id' => 1,
                'title' => 'Nacionalidades',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-flag',
                'color' => '#000000',
                'parent_id' => 40,
                'order' => 3,
                'created_at' => '2023-06-19 05:26:35',
                'updated_at' => '2023-07-05 07:44:03',
                'route' => 'voyager.nationalities.index',
                'parameters' => 'null',
            ),
            32 => 
            array (
                'id' => 40,
                'menu_id' => 1,
                'title' => 'Parametros',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-params',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 11,
                'created_at' => '2023-06-19 05:29:51',
                'updated_at' => '2023-07-12 22:20:27',
                'route' => NULL,
                'parameters' => '',
            ),
            33 => 
            array (
                'id' => 41,
                'menu_id' => 1,
                'title' => 'Paises',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-earth-americas',
                'color' => NULL,
                'parent_id' => 40,
                'order' => 4,
                'created_at' => '2023-06-20 02:18:39',
                'updated_at' => '2023-07-05 07:44:03',
                'route' => 'voyager.countries.index',
                'parameters' => NULL,
            ),
            34 => 
            array (
                'id' => 42,
                'menu_id' => 1,
                'title' => 'Departamentos',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-milestone',
                'color' => NULL,
                'parent_id' => 40,
                'order' => 5,
                'created_at' => '2023-06-20 02:22:32',
                'updated_at' => '2023-07-05 07:44:03',
                'route' => 'voyager.departments.index',
                'parameters' => NULL,
            ),
            35 => 
            array (
                'id' => 43,
                'menu_id' => 1,
                'title' => 'Provincias',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-pie-graph',
                'color' => NULL,
                'parent_id' => 40,
                'order' => 6,
                'created_at' => '2023-06-20 02:29:03',
                'updated_at' => '2023-07-05 07:44:03',
                'route' => 'voyager.provinces.index',
                'parameters' => NULL,
            ),
            36 => 
            array (
                'id' => 44,
                'menu_id' => 1,
                'title' => 'Ciudades',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'voyager-location',
                'color' => NULL,
                'parent_id' => 40,
                'order' => 7,
                'created_at' => '2023-06-20 02:33:33',
                'updated_at' => '2023-07-05 07:44:03',
                'route' => 'voyager.cities.index',
                'parameters' => NULL,
            ),
            37 => 
            array (
                'id' => 45,
                'menu_id' => 1,
                'title' => 'Productos de Limpieza',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-broom',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 9,
                'created_at' => '2023-07-05 06:56:10',
                'updated_at' => '2023-07-12 22:20:27',
                'route' => NULL,
                'parameters' => '',
            ),
            38 => 
            array (
                'id' => 46,
                'menu_id' => 1,
                'title' => 'Ingreso',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-cart-plus',
                'color' => '#000000',
                'parent_id' => 45,
                'order' => 1,
                'created_at' => '2023-07-05 07:01:01',
                'updated_at' => '2023-07-05 07:01:09',
                'route' => 'cleaningproducts.index',
                'parameters' => NULL,
            ),
            39 => 
            array (
                'id' => 47,
                'menu_id' => 1,
                'title' => 'Stock Disponible',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-brands fa-shopify',
                'color' => '#000000',
                'parent_id' => 45,
                'order' => 2,
                'created_at' => '2023-07-05 07:01:56',
                'updated_at' => '2023-07-05 07:53:58',
                'route' => 'cleaningproducts.stock',
                'parameters' => 'null',
            ),
            40 => 
            array (
                'id' => 48,
                'menu_id' => 1,
                'title' => 'Asignación De Limpieza',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-broom',
                'color' => '#000000',
                'parent_id' => 40,
                'order' => 8,
                'created_at' => '2023-07-12 16:14:27',
                'updated_at' => '2023-07-12 16:14:37',
                'route' => 'cleaning-asignation.index',
                'parameters' => NULL,
            ),
            41 => 
            array (
                'id' => 49,
                'menu_id' => 1,
                'title' => 'Limpiezas de Habitaciones',
                'url' => '',
                'target' => '_self',
                'icon_class' => 'fa-solid fa-broom-ball',
                'color' => '#000000',
                'parent_id' => NULL,
                'order' => 2,
                'created_at' => '2023-07-12 22:19:59',
                'updated_at' => '2023-07-12 22:20:27',
                'route' => 'cleaning.index',
                'parameters' => NULL,
            ),
        ));
        
        
    }
}