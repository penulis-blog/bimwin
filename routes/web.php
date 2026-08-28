<?php

use App\Models\M_web;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\C_beranda;
use App\Http\Controllers\C_blog;
use App\Http\Controllers\C_sitemap;

Route::get('/', [C_beranda::class, 'index']);
Route::get('/sertifikat-kegiatan', [C_beranda::class, 'unduh']);
Route::post('/sertifikat/unduh', [C_beranda::class, 'sertifikat']);
Route::get('/sertifikat/detail/{id}', [C_beranda::class, 'list_sertifikat']);
Route::get('/blog/{id}', [C_beranda::class, 'detail']);
Route::get('/sitemap-keluargasakinah.xml', [C_sitemap::class, 'index']);

Route::get('/blog', [C_blog::class, 'index']);
Route::post('/blog/pencarian', [C_blog::class, 'searching']);
Route::get('/tag/{id}', [C_blog::class, 'taging']);

$routes = M_web::get_routes();

foreach ($routes as $route) {
    $controllerClass = 'App\\Http\\Controllers\\' . $route->controller;

    if (!class_exists($controllerClass)) {
        throw new \Exception("Controller [$controllerClass] tidak ditemukan.");
    }

    if (!method_exists(app($controllerClass), $route->action)) {
        throw new \Exception("Method [{$route->action}] tidak ditemukan di [$controllerClass].");
    }

    $uri = $route->public_id;

    $routeDefinition = Route::match(
        [strtolower($route->methods)],
        $uri,
        [$controllerClass, $route->action]
    );

    if (!empty($route->name)) {
        $routeDefinition->name($route->name);
    } else {
        $routeDefinition->name($route->public_id);
    }

    if (!empty($route->middleware)) {
        $routeDefinition->middleware($route->middleware);
    }
}