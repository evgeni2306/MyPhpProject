<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AddPostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\ChangeTypeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

session_start();
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
Route::view('/', 'Login');
Route::get('/id={idd}', [\App\Http\Controllers\AnotherPageController::class, 'GetAnotherPage']);


//Route::get('/{aleas}', function () {
//    if (Auth::check()) {
//        return redirect(\route('user.private'));
//    }
//    return view('login');
//    //Этот роут будет кидать на страницу логина любые роуты, которых нету// недоделан
//});

// Routes для регистрации - авторизации
Route::name('user.')->group(function () {

    Route::get('/login', function () {
        if (Auth::check()) {
            return redirect(\route('user.private'));
        }
        return view('login');
    })->name('login');

    Route::get('/private', function () {
        if (Auth::check()) {
            if ($_SESSION['type'] == '2') {
                return view('anotherPageBanned');
            } else
                return view('private');
        }
        return redirect(\route('user.login'));
    })->name('private');

    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/logout', function () {
        session_destroy();
        Auth::logout();
        return redirect('/');
    })->name('logout');

    Route::get('/registration', function () {
        if (Auth::check()) {
            return redirect(\route('user.private'));
        }
        return view('registration');
    })->name('registration');

    Route::get('/pageEditor', function () {
        if (!Auth::check()) {
            return redirect(\route('user.login'));
        }
        if ($_SESSION['type'] == '2') {
            return redirect(route('user.private'));
        } else
            return view('PageEditor');
    })->name('pageEditor');

    Route::get('/addComment', function () {
        if (!Auth::check()) {
            return redirect(\route('user.login'));
        }
        return redirect()->intended('/id={' . $_SESSION['anotherId'] . '}');
    })->name('addComment');

    Route::get('/search', function () {
        if (!Auth::check()) {
            return redirect(\route('user.login'));
        }
        if ($_SESSION['type'] == '2') {
            return redirect(route('user.private'));
        } else
        return view('search');
    })->name('search');

    Route::get('/changeType', function () {
        if (!Auth::check()) {
            return redirect(\route('user.login'));
        }
        if ($_SESSION['type'] !='0') {
            return redirect(route('user.private'));
        } else
            return redirect()->intended('/id={' . $_SESSION['anotherId'] . '}');
    })->name('changeType');

    Route::get('/changeType', [ChangeTypeController::class, 'UpdateType']);
    Route::post('/search', [SearchController::class, 'Search']);
    Route::post('/private', [AddPostController::class, 'AddMyPost']);
    Route::post('/addComment', [AddPostController::class, 'AddPost']);
    Route::post('/registration', [RegisterController::class, 'Save']);
    Route::post('/pageEditor', [EditorController::class, 'Update']);
});




