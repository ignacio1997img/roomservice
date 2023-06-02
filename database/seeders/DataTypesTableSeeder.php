<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DataTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('data_types')->delete();
        
        \DB::table('data_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'users',
                'slug' => 'users',
                'display_name_singular' => 'User',
                'display_name_plural' => 'Users',
                'icon' => 'voyager-person',
                'model_name' => 'App\\Models\\User',
                'policy_name' => 'TCG\\Voyager\\Policies\\UserPolicy',
                'controller' => 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController',
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"desc","default_search_key":null,"scope":null}',
                'created_at' => '2023-03-17 06:13:54',
                'updated_at' => '2023-06-01 14:24:00',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'menus',
                'slug' => 'menus',
                'display_name_singular' => 'Menu',
                'display_name_plural' => 'Menus',
                'icon' => 'voyager-list',
                'model_name' => 'TCG\\Voyager\\Models\\Menu',
                'policy_name' => NULL,
                'controller' => '',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2023-03-17 06:13:54',
                'updated_at' => '2023-03-17 06:13:54',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'roles',
                'slug' => 'roles',
                'display_name_singular' => 'Role',
                'display_name_plural' => 'Roles',
                'icon' => 'voyager-lock',
                'model_name' => 'TCG\\Voyager\\Models\\Role',
                'policy_name' => NULL,
                'controller' => 'TCG\\Voyager\\Http\\Controllers\\VoyagerRoleController',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2023-03-17 06:13:54',
                'updated_at' => '2023-03-17 06:13:54',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'people',
                'slug' => 'people',
                'display_name_singular' => 'Persona',
                'display_name_plural' => 'Personas',
                'icon' => 'voyager-people',
                'model_name' => 'App\\Models\\People',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2023-03-17 08:33:00',
                'updated_at' => '2023-03-22 06:57:04',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'categories',
                'slug' => 'categories',
                'display_name_singular' => 'Categoria Articulo',
                'display_name_plural' => 'Categorias de Articulos',
                'icon' => 'voyager-categories',
                'model_name' => 'App\\Models\\Category',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null}',
                'created_at' => '2023-03-17 11:46:13',
                'updated_at' => '2023-03-17 11:46:13',
            ),
            5 => 
            array (
                'id' => 9,
                'name' => 'articles',
                'slug' => 'articles',
                'display_name_singular' => 'Artículo',
                'display_name_plural' => 'Articulos',
                'icon' => 'fa-solid fa-tag',
                'model_name' => 'App\\Models\\Article',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2023-03-17 16:40:55',
                'updated_at' => '2023-03-18 18:24:13',
            ),
            6 => 
            array (
                'id' => 11,
                'name' => 'categories_facilities',
                'slug' => 'categories-facilities',
                'display_name_singular' => 'Planta de Hotel',
                'display_name_plural' => 'Plantas de Hoteles',
                'icon' => 'fa-solid fa-puzzle-piece',
                'model_name' => 'App\\Models\\CategoriesFacility',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2023-03-18 20:04:50',
                'updated_at' => '2023-03-18 20:10:48',
            ),
            7 => 
            array (
                'id' => 12,
                'name' => 'categories_rooms',
                'slug' => 'categories-rooms',
                'display_name_singular' => 'Categoría de Habitación',
                'display_name_plural' => 'Categorías de Habitaciones',
                'icon' => 'voyager-categories',
                'model_name' => 'App\\Models\\CategoriesRoom',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2023-03-18 20:20:51',
                'updated_at' => '2023-03-18 20:27:31',
            ),
            8 => 
            array (
                'id' => 13,
                'name' => 'parts_hotels',
                'slug' => 'parts-hotels',
                'display_name_singular' => 'Partes del Hotel',
                'display_name_plural' => 'Partes del Hotel',
                'icon' => 'fa-solid fa-list',
                'model_name' => 'App\\Models\\PartsHotel',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2023-03-20 09:11:53',
                'updated_at' => '2023-03-20 09:15:49',
            ),
            9 => 
            array (
                'id' => 14,
                'name' => 'food',
                'slug' => 'food',
                'display_name_singular' => 'Comida',
                'display_name_plural' => 'Comidas',
                'icon' => 'fa-solid fa-bowl-food',
                'model_name' => 'App\\Models\\Food',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2023-03-28 20:37:44',
                'updated_at' => '2023-03-28 21:31:48',
            ),
            10 => 
            array (
                'id' => 15,
                'name' => 'food_menus',
                'slug' => 'food-menus',
                'display_name_singular' => 'Menú',
                'display_name_plural' => 'Menú del Día',
                'icon' => 'fa-solid fa-list',
                'model_name' => 'App\\Models\\FoodMenu',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2023-03-28 20:49:56',
                'updated_at' => '2023-03-28 20:54:58',
            ),
            11 => 
            array (
                'id' => 16,
                'name' => 'rooms',
                'slug' => 'rooms',
                'display_name_singular' => 'Room',
                'display_name_plural' => 'Rooms',
                'icon' => 'fa-solid fa-person-booth',
                'model_name' => 'App\\Models\\Room',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2023-06-02 15:09:34',
                'updated_at' => '2023-06-02 15:31:38',
            ),
        ));
        
        
    }
}