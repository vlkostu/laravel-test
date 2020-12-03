<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\StatisticController;
use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group([
        'middleware' => [
            'throttle:20', 'ApiRequestHit', 'web'
        ],
    ], function (Router $api) {
        # Auth
        $api->group([
            'prefix' => 'auth'
        ], function (Router $api) {
            $api->post('/login', [AuthController::class, 'login']);
            $api->post('/register', [AuthController::class, 'register']);
            $api->post('/logout', [AuthController::class, 'logout']);
        });
        # Episodes
        $api->group([
            'prefix' => 'episodes'
        ], function (Router $api) {
            $api->get('/', [EpisodeController::class, 'getAll']);
            $api->get('/{episode}', [EpisodeController::class, 'getByID']);
        });
        # Characters
        $api->group([
            'prefix' => 'characters'
        ], function (Router $api) {
            $api->get('/', [CharacterController::class, 'getAll']);
            $api->get('/random', [CharacterController::class, 'getRandom']);
        });
        # Quotes
        $api->group([
            'prefix' => 'quotes'
        ], function (Router $api) {
            $api->get('/', [QuoteController::class, 'getAll']);
            $api->get('/random', [QuoteController::class, 'getRandom']);
        });
        # Statistic
        $api->group([
            'prefix' => 'statistic'
        ], function (Router $api) {
            $api->get('/', [StatisticController::class, 'getAll']);
            $api->get('/my', [StatisticController::class, 'getUser']);
        });
        $api->get('/images', [ImageController::class, 'getAll']);
        $api->post('/images', [ImageController::class, 'upload']);
    });
});
