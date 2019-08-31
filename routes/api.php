<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1',[
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => 'serializer:array'
], function ($api) {
   $api->group([
       'middleware' => 'api.throttle',
       'limit' => config('api.rate_limits.access.limit'),
       'expires' => config('api.rate_limits.access.expires'),
   ], function ($api) {
       // 游客可以访问的接口
       $api->get('categories', 'CategoriesController@index')
           ->name('api.categories.index');

       // 需要 token 验证的接口
   });
});



