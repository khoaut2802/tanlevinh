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

Route::group(['prefix' => getSetting('admin_prefix')], function($router) {

    $router->group(['middleware' => ['auth', 'auth.admin']], function ($router) {
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
            
            $router->get('/{id}', 'GroupController@detail')->name('group_detail');
            $router->post('/{id}/order', 'GroupController@order')->name('group_order');
            $router->post('/{id}/delete', 'GroupController@delete')->name('group_delete');
        });

        $router->group(['prefix' => 'attributes'], function($router) {
            $router->get('/', 'AttributesController@index')->name('attributes');

            $router->post('/add', 'AttributesController@store')->name('attributes_add');
            $router->post('/update', 'AttributesController@update')->name('attributes_update');
            $router->post('/delete', 'AttributesController@delete')->name('attributes_delete');
        });

        $router->group(['prefix' => 'menu'], function($router) {
            $router->get('/', 'MenuController@index')->name('menu');

            $router->post('/add', 'MenuController@store')->name('menu_add');
            $router->post('/{id}/delete', 'MenuController@delete')->name('menu_delete');
        });

        $router->group(['prefix' => 'banners'], function($router) {
            $router->get('/', 'BannerController@index')->name('banners');

            $router->post('/add', 'BannerController@store')->name('banner_add');
            $router->post('/{id}/delete', 'BannerController@delete')->name('banner_delete');
        });

        $router->group(['prefix' => 'settings'], function($router) {
            $router->get('/', 'SettingsController@index')->name('settings');

            $router->post('/update', 'SettingsController@update')->name('settings_update');
        });
        
        $router->group(['prefix' => 'orders'], function($router) {
            $router->post('/create', 'OrdersController@store')->name('orders_create');
        });
    });                 

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

Route::group(['prefix' => 'user', 'middleware' => 'auth.user', 'as' => 'user.'], function($router) {
    $router->get('/', 'UserController@index')->name('dashboard');
    $router->get('/profile', 'UserController@profile')->name('profile');
    $router->get('/password', 'UserController@password')->name('password');

    $router->post('/update', 'UserController@update')->name('update');
    $router->post('/update-password', 'UserController@updatePassword')->name('update.password');

    $router->group(['prefix' => 'order'], function($router) {
        $router->get('/detail/{code}', 'UserController@detailOrder')->name('order.detail');
        
        $router->post('/create', 'UserController@createOrder')->name('order.create');

        $router->post('/cancel', 'UserController@cancelOrder')->name('order.cancel');
    });
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

$router->get('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')
->name('logout2');