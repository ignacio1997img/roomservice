<?php

use App\Http\Controllers\CategoryRoomController;
use App\Http\Controllers\CleaningProductController;
use App\Http\Controllers\FoodMenuController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ServiceRoomController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\WorkerController;
use App\Models\CategoriesRoom;
use App\Models\Income;
use App\Models\ServiceRoom;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect('admin/login');
})->name('login');

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['prefix' => 'admin', 'middleware' => 'loggin'], function () {
    Voyager::routes();

    Route::get('people', [PeopleController::class, 'index'])->name('voyager.people.index');
    Route::post('people/store', [PeopleController::class, 'store']);
    Route::get('people/ajax/list/{search?}', [PeopleController::class, 'list']);

    Route::resource('incomes', IncomeController::class);
    Route::get('incomes/ajax/list/{search?}', [IncomeController::class, 'list']);
    Route::get('income/article/ajax', [IncomeController::class, 'ajaxArticle']);//para poder obtener los particulos o productos
    Route::get('incomes-article/stock', [IncomeController::class, 'indexStock'])->name('income-article.stock');
    Route::get('incomes/article/stock/ajax/list/{search?}', [IncomeController::class, 'listStock']);
    // Para obtener la lista de article en stock
    Route::get('incomes/article/stock/ajax', [IncomeController::class, 'ajaxProductExists']);//para poder obtener los particulos o productos



    Route::resource('worker', WorkerController::class);
    Route::get('worker/ajax/list/{search?}', [WorkerController::class, 'list']);
    Route::get('worker/people/ajax', [WorkerController::class, 'ajaxPeople']);//para poder obtener los particulos o productos
    Route::get('worker/category/ajax', [WorkerController::class, 'ajaxCategory']);//para poder obtener los particulos o productos
    Route::post('worker/category/store', [WorkerController::class, 'storeCategory'])->name('worker-category.store');
    Route::delete('worker/{worker?}/category/delete', [WorkerController::class, 'deleteCategory'])->name('worker-category.delete');


    Route::get('categories_rooms', [CategoryRoomController::class, 'index'])->name('voyager.categories-rooms.index');
    Route::get('categories_room/{room?}', [CategoryRoomController::class, 'show'])->name('voyager.categories-rooms.show');
    Route::post('categories_rooms/store', [CategoryRoomController::class, 'store'])->name('categories-rooms.store');
    
    Route::delete('categories-rooms/{room?}/delete', [CategoryRoomController::class, 'destroy'])->name('categories-rooms.delete');
    Route::get('categories-rooms/parthotel/ajax', [CategoryRoomController::class, 'ajaxPartsHotel']);//para poder obtener las partes que conformara el hotel
    Route::get('categories-rooms/ajax/list/{search?}', [CategoryRoomController::class, 'list']);


    Route::resource('rooms', RoomController::class);
    Route::get('rooms', [RoomController::class, 'index'])->name('voyager.rooms.index');
    Route::get('rooms/edit/{id?}', [RoomController::class, 'show'])->name('voyager.rooms.show');
    Route::delete('rooms/delete/{id?}', [RoomController::class, 'destroy'])->name('rooms.destroy');
    Route::get('rooms/ajax/list/{search?}', [RoomController::class, 'list']);
    Route::post('room/read/part/store', [RoomController::class, 'storePart'])->name('room-read-part.store');
    Route::delete('room/{part?}/part/delete', [RoomController::class, 'deletePart'])->name('room-rooms-part.delete');

    
    Route::get('view/planta/{planta?}', [ViewController::class, 'index'])->name('view.planta');//paar ver todas la habitaciones de cada planta
    Route::get('view/planta/room/{room?}', [ViewController::class, 'viewAsignar'])->name('view-planta.room');
    Route::get('view/planta/room/{room?}/read', [ViewController::class, 'readAsignar'])->name('view-planta-room.read');

    Route::post('serviceroom/store', [ServiceRoomController::class, 'store'])->name('serviceroom.store');
    // para agregar productos a una pieza o habitacion
    Route::post('serviceroom/article/store', [IncomeController::class, 'storeEgressPieza'])->name('serviceroom-article.store');//para agregar un producto a la venta en una habitacion
    Route::post('serviceroom/foodmenu/store', [FoodMenuController::class, 'storeEgressPieza'])->name('serviceroom-foodmenu.store');//para agregar una comida a la venta en una habitacion
    Route::post('serviceroom/extra/store', [ServiceRoomController::class, 'storeExtra'])->name('serviceroom-extra.store');//para registrar los servicios extras de cada habitacion ocupada
    Route::get('food/menu/list/ajax', [FoodMenuController::class, 'ajaxMenuExists']);//para poder obtene el menu del dia
    Route::get('serviceroom/finish/article/{id?}', [IncomeController::class, 'ajaxFinishPieza'])->name('serviceroom-finish.article');//para poder obtener los detalle de venta producto del dia para finalizar el ospedaje
    Route::get('serviceroom/finish/menu/{id?}', [FoodMenuController::class, 'ajaxFinishPieza'])->name('serviceroom-finish.menu');//para poder obtener los menu o comida del dia para finalizar el ospedaje
    Route::get('serviceroom/finish/extra/{id?}', [ServiceRoomController::class, 'ajaxFinishPiezaExtra'])->name('serviceroom-finish.extra');//para poder obtener los servicios extras para finalizar el ospedaje
    Route::get('serviceroom/finish/room/{id?}/{dateFinish?}', [ServiceRoomController::class, 'ajaxFinishPieza'])->name('serviceroom-finish.rooms');//Para poder calcular la fecha o los dias de hospedaje y el total de deuda de solo la habitacion
    Route::post('serviceroom/hospedaje/close', [ServiceRoomController::class, 'closeFinishRoom'])->name('serviceroom-hospedaje-close');    //Para poder finalizar el hospedaje de la habitracion

    Route::post('serviceroom/hospedaje/cancel', [ServiceRoomController::class, 'hospedajeCancel'])->name('serviceroom-hospedaje.cancel');    //Para poder cancelar el hospedaje de las habitaciones hospedaje
    Route::post('serviceroom/hospedaje/reserva/cancel', [ServiceRoomController::class, 'reservaCancelar'])->name('serviceroom-hospedaje-reserva.cancel');    //Para poder cancelar la reserva de una habitacion en el hotel
    Route::post('serviceroom/hospedaje/reserva/start', [ServiceRoomController::class, 'reservaStart'])->name('serviceroom-hospedaje-reserva.start');    //Para poder cancelar la reserva de una habitacion en el hotel
    Route::post('serviceroom/hospedaje/addmoney', [ServiceRoomController::class, 'addMoney'])->name('serviceroom-hospedaje.addmoney');


    Route::resource('sales', SaleController::class);
    Route::get('sales/ajax/list/{search?}', [SaleController::class, 'list']);


    // ::::::::::::::::::::::   Para registro de produtos de limpieza  :::::::::::::::::::
    Route::resource('cleaningproducts', CleaningProductController::class);
    Route::get('cleaningproducts/ajax/list/{search?}', [CleaningProductController::class, 'list']);








    //para los reportes de ventas de productos habitaciones o personas invidual
    Route::get('report-saleproductserviceroom', [ReportController::class, 'saleProductServiceRoom'])->name('report.saleproductserviceroom');
    Route::post('report-saleproductserviceroom/list', [ReportController::class, 'saleProductServiceRoomList'])->name('report-saleproductserviceroom.list');

    //Para los reportes de ventas de comidas o menu al hotel habitacione
    Route::get('report-salefoodserviceroom', [ReportController::class, 'saleFoodServiceRoom'])->name('report.salefoodserviceroom');
    Route::post('report-salefoodserviceroom/list', [ReportController::class, 'saleFoodServiceRoomList'])->name('report-salefoodserviceroom.list');





});


Route::get('/admin/clear-cache', function() {
    Artisan::call('optimize:clear');
    return redirect('/admin')->with(['message' => 'Cache eliminada.', 'alert-type' => 'success']);
})->name('clear.cache');
