<?php

use Illuminate\Support\Facades\Auth;
use App\User;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::get('/generate', function() {
    $user = Auth::user();
    $user->tokens()->delete();
    $token = $user->createToken('token-name');
    return $token->plainTextToken;
});

Route::get('/app/{vue_capture?}', 'HomeController@index')->where('vue_capture', '[\/\w\.-]*');

Route::get('/{any?}', function() {
    return redirect('/app');
})->where('any', '[\/\w\.-]*');