<?php declare(strict_types=1);

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'v1'], function () use ($router) {
    // Authenticated routes
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('posts', ['uses' => 'PostController@index']);
        $router->post('posts', ['uses' => 'PostController@store']);
        $router->get('posts/{id}', ['uses' => 'PostController@show']);
        $router->put('posts/{id}', ['uses' => 'PostController@update']);
        $router->delete('posts/{id}', ['uses' => 'PostController@destroy']);
    });
});
