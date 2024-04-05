<?php

use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Monolog\Level;

Route::get('/',[WelcomeController::class,'index']);

Route::group(['prefix' => 'user'], function(){
    Route::get('/', [UserController::class, 'index']);          //menampilkan halaman awal user
    Route::post('/list', [UserController::class,'list']);       //menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class,'create']);    //menampilkan halaman form tambah user
    Route::post('/', [UserController::class,'store']);          //menyimpan data user baru  
    Route::get('/{id}', [UserController::class,'show']);        //menampilkan detail user
    Route::get('/{id}/edit', [UserController::class,'edit']);   //menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class,'update']);      //menyimpan perubahan data user
    Route::delete('/{id}', [UserController::class,'destroy']);  //menghapus data user
});
Route::group(['prefix' => 'level'], function(){
    Route::get('/', [LevelController::class, 'index']);          
    Route::post('/list', [LevelController::class,'list']);       
    Route::get('/create', [LevelController::class,'create']);    
    Route::post('/', [LevelController::class,'store']);           
    Route::get('/{id}', [LevelController::class,'show']);        
    Route::get('/{id}/edit', [LevelController::class,'edit']);   
    Route::put('/{id}', [LevelController::class,'update']);      
    Route::delete('/{id}', [LevelController::class,'destroy']);  
});