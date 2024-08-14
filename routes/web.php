<?php

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

// ==============================================
// ALL ROUTES MUST HAVE NAME FOR PERMISSION CHECK
// ==============================================
Route::group([], function(){
    Route::fallback(function () {
        session()->flush();
        return view('404');
    })->name('site.404');
});

Route::get('/', 'App\Http\Controllers\Site@home')->name('site.home');
Route::get('/banner/mes-do-nordestino', 'App\Http\Controllers\Site@bannerMesDoNordestino')->name('site.banner.mesDoNordestino');
Route::get('/banner/top-of-mind', 'App\Http\Controllers\Site@bannerTopOfMind')->name('site.banner.topOfMind');
Route::get('/banner/cirio-de-nazare', 'App\Http\Controllers\Site@cirioDeNazare')->name('site.banner.cirioDeNazare');
Route::get('/banner/primor-60', 'App\Http\Controllers\Site@primor60')->name('site.banner.primor60');
Route::get('/banner/sabor-que-conta', 'App\Http\Controllers\Site@saborQueConta')->name('site.banner.saborQueConta');
Route::get('/produtos', 'App\Http\Controllers\Site@produtos')->name('site.produtos');
Route::get('/produtos/{slug}', 'App\Http\Controllers\Site@produtosSingle')->name('site.produtosSingle');
Route::get('/receitas', 'App\Http\Controllers\Site@receitas')->name('site.receitas');
Route::get('/receitas/{slug}', 'App\Http\Controllers\Site@receitaSingle')->name('site.receitaSingle');
Route::get('/campanha', 'App\Http\Controllers\Site@campanha')->name('site.campanha');
Route::get('/nossa-historia', 'App\Http\Controllers\Site@nossaHistoria')->name('site.nossaHistoria');
Route::get('/fale-conosco', 'App\Http\Controllers\Site@faleConosco')->name('site.faleConosco');
Route::post('/do-fale-conosco', 'App\Http\Controllers\Site@doFaleConosco')->name('site.doFaleConosco');
Route::get('/politica-de-privacidade', 'App\Http\Controllers\Site@politicaDePrivacidade')->name('site.politicaDePrivacidade');