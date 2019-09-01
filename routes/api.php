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
    'middleware' => ['serializer:array', 'bindings']
], function ($api) {
   $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
   ], function ($api) {
       // 注册
       $api->post('register', 'RegisterController@store')
           ->name('api.register.store');

       // 登录
       $api->post('authorizations', 'AuthorizationsController@store')
           ->name('api.authorizations.store');
   });
   $api->group([
       'middleware' => 'api.throttle',
       'limit' => config('api.rate_limits.access.limit'),
       'expires' => config('api.rate_limits.access.expires'),
   ], function ($api) {
       // 游客可以访问的接口
       $api->get('categories', 'CategoriesController@index')
           ->name('api.categories.index');
       $api->get('topics', 'TopicsController@index')
           ->name('api.topics.index');
       $api->get('users/{user}/topics', 'TopicsController@userIndex')
           ->name('api.users.topics.index');
       $api->get('topics/{topic}', 'TopicsController@show')
           ->name('api.topics.show');

       // 需要 token 验证的接口

       //发布话题
       $api->post('topics', 'TopicsController@store')
           ->name('api.topics.store');
       $api->patch('topics/{topic}', 'TopicsController@update')
           ->name('api.topics.update');
       $api->delete('topics/{topic}', 'TopicsController@destroy')
           ->name('api.topics.destroy');

   });
});



