<?php declare(strict_types=1);

use App\Http\Controllers\TemplateController;
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

        $router->get('templates', ['uses' => 'TemplateController@index']);
        $router->post('templates', ['uses' => 'TemplateController@store']);
        $router->get('templates/{id}', ['uses' => 'TemplateController@show']);
        $router->put('templates/{id}', ['uses' => 'TemplateController@update']);
        $router->delete('templates/{id}', ['uses' => 'TemplateController@destroy']);
        
    });
});