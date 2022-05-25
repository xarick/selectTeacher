<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('faculties', FacultyController::class);
    $router->resource('teachers', TeacherController::class);
    $router->resource('years', YearController::class);
    $router->resource('courses', CourseController::class);
    $router->resource('groups', GroupController::class);

});
