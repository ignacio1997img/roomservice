<?php

use App\Http\Controllers\CategoryRoomController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\WorkerController;
use App\Models\CategoriesRoom;
use App\Models\Income;
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
});

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('people', [PeopleController::class, 'index'])->name('voyager.people.index');
    Route::get('people/ajax/list/{search?}', [PeopleController::class, 'list']);

    Route::resource('incomes', IncomeController::class);
    Route::get('incomes/ajax/list/{search?}', [IncomeController::class, 'list']);
    Route::get('income/article/ajax', [IncomeController::class, 'ajaxArticle']);//para poder obtener los particulos o productos
    Route::get('incomes/article/stock', [IncomeController::class, 'indexStock'])->name('income-article.stock');
    Route::get('incomes/article/stock/ajax/list/{search?}', [IncomeController::class, 'listStock']);


    Route::resource('worker', WorkerController::class);
    Route::get('worker/ajax/list/{search?}', [WorkerController::class, 'list']);
    Route::get('worker/people/ajax', [WorkerController::class, 'ajaxPeople']);//para poder obtener los particulos o productos
    Route::get('worker/category/ajax', [WorkerController::class, 'ajaxCategory']);//para poder obtener los particulos o productos
    Route::post('worker/category/store', [WorkerController::class, 'storeCategory'])->name('worker-category.store');
    Route::delete('worker/{worker?}/category/delete', [WorkerController::class, 'deleteCategory'])->name('worker-category.delete');


    Route::get('categories-rooms', [CategoryRoomController::class, 'index'])->name('voyager.categories-rooms.index');
    Route::get('categories-room/{room?}', [CategoryRoomController::class, 'show'])->name('voyager.categories-rooms.show');
    Route::post('categories-rooms/store', [CategoryRoomController::class, 'store'])->name('categories-rooms.store');
    Route::delete('categories-rooms/{room?}/delete', [CategoryRoomController::class, 'destroy'])->name('categories-rooms.delete');
    Route::get('categories-rooms/parthotel/ajax', [CategoryRoomController::class, 'ajaxPartsHotel']);//para poder obtener las partes que conformara el hotel
    Route::get('categories-rooms/ajax/list/{search?}', [CategoryRoomController::class, 'list']);
    Route::delete('categories-rooms/{part?}/part/delete', [CategoryRoomController::class, 'deletePart'])->name('categories-rooms-part.delete');


    Route::resource('room', RoomController::class);
    Route::get('room/ajax/list/{search?}', [RoomController::class, 'list']);




});


Route::get('/admin/clear-cache', function() {
    Artisan::call('optimize:clear');
    return redirect('/admin')->with(['message' => 'Cache eliminada.', 'alert-type' => 'success']);
})->name('clear.cache');
