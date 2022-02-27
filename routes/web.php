<?php declare(strict_types=1);

use App\Models\User;

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'v1'], function () use ($router) {
    // Authenticated routes
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('users', function () {
            return User::search()->get();
        });

        $router->get('posts', ['as' => 'posts.index', 'uses' => 'PostController@index']);
        $router->post('posts', ['as' => 'posts.store', 'uses' => 'PostController@store']);
        $router->get('posts/{id}', ['as' => 'posts.show', 'uses' => 'PostController@show']);
        $router->put('posts/{id}', ['as' => 'posts.update', 'uses' => 'PostController@update']);
        $router->delete('posts/{id}', ['as' => 'post.destroy', 'uses' => 'PostController@destroy']);
    });
});
