<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => env('DASHBOARD_PREFIX')], function($router) {

    $router->group(['middleware' => 'auth'], function ($router) {
        $router->get('/', 'DashboardController@index')->name('dashboard');

        $router->group(['prefix' => 'products'], function($router) {
            $router->get('/', 'ProductController@index')->name('products');
            $router->post('/', 'ProductController@index')->name('product_search');

            $router->post('/add', 'ProductController@store')->name('add_product');

            $router->get('/update/{id}', 'ProductController@updateView')->name('product_update');
            $router->post('/update/{id}', 'ProductController@update')->name('product_update_submit');
            $router->post('/{id}/get-attr', 'ProductController@getAttr')->name('product_get_attr');
            $router->post('/{id}/delete', 'ProductController@delete')->name('product_delete');
        });

        $router->group(['prefix' => 'groups'], function($router) {
            $router->get('/', 'GroupController@index')->name('groups');
            $router->post('/', 'GroupController@index')->name('group_search');
        
            $router->post('/add', 'GroupController@store')->name('add_group');            
        });
       


        $router->get('/menu', 'DashboardController@products')->name('menu');
        $router->get('/banners', 'DashboardController@products')->name('banners');
        $router->get('/settings', 'DashboardController@products')->name('settings');

        //POST
        

    });

    $router->get('/register', [RegisteredUserController::class, 'create'])
                    ->middleware('guest')
                    ->name('register');

    $router->post('/register', [RegisteredUserController::class, 'store'])
                    ->middleware('guest');

    $router->get('/login', [AuthenticatedSessionController::class, 'create'])
                    ->middleware('guest')
                    ->name('login');

    $router->post('/login', [AuthenticatedSessionController::class, 'store'])
                    ->middleware('guest');

    $router->post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');                    

    // $router->get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    //                 ->middleware('guest')
    //                 ->name('password.request');

    // $router->post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    //                 ->middleware('guest')
    //                 ->name('password.email');

    // $router->get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    //                 ->middleware('guest')
    //                 ->name('password.reset');

    // $router->post('/reset-password', [NewPasswordController::class, 'store'])
    //                 ->middleware('guest')
    //                 ->name('password.update');

    // $router->get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
    //                 ->middleware('auth')
    //                 ->name('verification.notice');

    // $router->get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    //                 ->middleware(['auth', 'signed', 'throttle:6,1'])
    //                 ->name('verification.verify');

    // $router->post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    //                 ->middleware(['auth', 'throttle:6,1'])
    //                 ->name('verification.send');

    // $router->get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
    //                 ->middleware('auth')
    //                 ->name('password.confirm');

    // $router->post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
    //                 ->middleware('auth');

});