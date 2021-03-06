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

    $router->group(['middleware' => ['auth', 'auth.not_user']], function ($router) {
        $router->get('/', 'DashboardController@index')->name('dashboard');

        $router->group(['prefix' => 'products', 'middleware' => 'auth.admin'], function($router) {
            $router->get('/', 'ProductController@index')->name('products');
            $router->post('/', 'ProductController@index')->name('product_search');

            $router->post('/add', 'ProductController@store')->name('add_product');

            $router->get('/update/{id}', 'ProductController@updateView')->name('product_update');
            $router->post('/update/{id}', 'ProductController@update')->name('product_update_submit');
            $router->post('/{id}/get-attr', 'ProductController@getAttr')->name('product_get_attr');
            $router->post('/{id}/delete', 'ProductController@delete')->name('product_delete');
        });

        $router->group(['prefix' => 'groups', 'middleware' => 'auth.admin'], function($router) {
            $router->get('/', 'GroupController@index')->name('groups');
            $router->post('/', 'GroupController@index')->name('group_search');

            $router->post('/add', 'GroupController@store')->name('add_group');

            $router->get('/{id}', 'GroupController@detail')->name('group_detail');
            $router->post('/{id}/order', 'GroupController@order')->name('group_order');
            $router->post('/{id}/delete', 'GroupController@delete')->name('group_delete');
        });

        $router->group(['prefix' => 'attributes', 'middleware' => 'auth.admin'], function($router) {
            $router->get('/', 'AttributesController@index')->name('attributes');

            $router->post('/add', 'AttributesController@store')->name('attributes_add');
            $router->post('/update', 'AttributesController@update')->name('attributes_update');
            $router->post('/delete', 'AttributesController@delete')->name('attributes_delete');
        });

        $router->group(['prefix' => 'menu', 'middleware' => 'auth.admin'], function($router) {
            $router->get('/', 'MenuController@index')->name('menu');

            $router->post('/add', 'MenuController@store')->name('menu_add');
            $router->post('/{id}/delete', 'MenuController@delete')->name('menu_delete');
        });

        $router->group(['prefix' => 'banners', 'middleware' => 'auth.admin'], function($router) {
            $router->get('/', 'BannerController@index')->name('banners');

            $router->post('/add', 'BannerController@store')->name('banner_add');
            $router->post('/{id}/delete', 'BannerController@delete')->name('banner_delete');
        });

        $router->group(['prefix' => 'settings', 'middleware' => 'auth.admin'], function($router) {
            $router->get('/', 'SettingsController@index')->name('settings');

            $router->post('/update', 'SettingsController@update')->name('settings_update');
        });

        $router->group(['prefix' => 'orders'], function($router) {
            $router->get('/', 'OrdersController@index')->name('orders');
            $router->get('/detail/{id}', 'OrdersController@detail')->name('orders_detail');
            // $router->post('/', 'OrdersController@index')->name('orders_search');
            $router->group(['middleware' => 'auth.admin'], function($router) {
                $router->get('/print/{code}', 'OrdersController@print')->name('order_print');
                $router->post('/machine/{id?}', 'OrdersController@updateMachine')->name('order.update_machine');
                $router->post('/update', 'OrdersController@update')->name('orders_update');
                $router->post('/store', 'OrdersController@store')->name('orders.create');
                $router->post('/{code}/update', 'OrdersController@updateV2')->name('orders.update.v2');
                $router->get('/{code}/show', 'OrdersController@show')->name('orders.show');
                $router->get('/show-create-modal', 'OrdersController@show')->name('orders.show');
                $router->get('/export', 'OrdersController@export')->name('orders.export');
            });

            $router->group(['middleware' => 'auth.staff'], function($router) {
                $router->post('/staff-update', 'OrdersController@staffUpdate')->name('order.staff.update');
            });
        });

        $router->group(['prefix' => 'pages', 'middleware' => 'auth.admin'], function($router) {
            $router->get('/', 'PagesController@index')->name('pages');

            $router->get('/page/{id?}', 'PagesController@detail')->name('pages.edit');
            $router->post('/page/{id?}', 'PagesController@store')->name('pages.create');
            $router->post('/page/{id?}/delete', 'PagesController@delete')->name('pages.delete');
        });

        $router->group(['prefix' => 'users', 'middleware' => 'auth.admin'], function($router) {
            $router->get('/', 'UsersController@index')->name('users');

            $router->post('/store', 'UsersController@store')->name('users_create');
            $router->get('/{id}/detail', 'UsersController@detail')->name('users_detail');
            $router->post('/{id}/delete', 'UsersController@delete')->name('users_delete');
            $router->post('/update', 'UsersController@update')->name('users_update');
        });

        $router->group(['prefix' => 'machines', 'middleware' => 'auth.admin'], function($router) {
            $router->get('/', 'MachinesController@index')->name('machines');
            $router->post('/', 'MachinesController@store')->name('machine.store');
            $router->post('/delete/{id}', 'MachinesController@delete')->name('machine.delete');
        });

        $router->group(['prefix' => 'ajax', 'middleware' => 'auth.admin'], function($router) {
            $router->get('/groups/{id}', 'GroupController@getProducts');
            $router->get('/product/{id}', 'ProductController@getAttrs');
        });
    });

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
        $router->post('/upload', 'UserController@uploadFile')->name('order.upload');

        $router->get('/patrons', 'UserController@patrons')->name('patrons');
        $router->get('/patron', 'UserController@patronOrderView')->name('patron');
        $router->post('/patron', 'UserController@patronOrder')->name('patron.order');
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

$router->get('/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->middleware('guest')
                ->name('password.request');

$router->post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest')
                ->name('password.email');

$router->get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->middleware('guest')
                ->name('password.reset');

$router->post('/reset-password', [NewPasswordController::class, 'store'])
                ->middleware('guest')
                ->name('password.update');
