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

       // 刷新token
       $api->put('authorizations/current', 'AuthorizationsController@update')
           ->name('api.authorizations.update');
       // 删除token
       $api->delete('authorizations/current','AuthorizationsController@destroy')
           ->name('api.authorizations.destroy');
   });
   $api->group([
       'middleware' => 'api.throttle',
       'limit' => config('api.rate_limits.access.limit'),
       'expires' => config('api.rate_limits.access.expires'),
   ], function ($api) {
       // 游客可以访问的接口
       $api->get('categories', 'CategoriesController@index')
           ->name('api.categories.index');
       $api->get('categories/{category}', 'CategoriesController@show')
           ->name('api.categories.show');
       $api->get('topics', 'TopicsController@index')
           ->name('api.topics.index');
       $api->get('users/{user}/topics', 'TopicsController@userIndex')
           ->name('api.users.topics.index');
       $api->get('topics/{topic}', 'TopicsController@show')
           ->name('api.topics.show');

       // 话题回复列表
       $api->get('topics/{topic}/replies', 'RepliesController@index')
           ->name('api.topics.replies.index');

       // 需要 token 验证的接口
       $api->group(['middleware' => 'api.auth'], function ($api) {
            //当前登录用户信息
           $api->get('user', 'UsersController@me')
               ->name('api.user.show');
           // 编辑登录用户信息
           $api->patch('user', 'UsersController@update')
               ->name('api.user.update');
           // 图片资源
           $api->post('images', 'ImagesController@store')
               ->name('api.images.store');

           //发布话题
           $api->post('topics', 'TopicsController@store')
               ->name('api.topics.store');
           $api->patch('topics/{topic}', 'TopicsController@update')
               ->name('api.topics.update');
           $api->delete('topics/{topic}', 'TopicsController@destroy')
               ->name('api.topics.destroy');

           //点赞 取消点赞
           $api->post('/topics/{topic}/zans', 'ZansController@store')
               ->name('api.topics.zans.store');
           $api->delete('/topics/{topic}/zans', 'ZansController@destroy')
               ->name('api.topics.zans.destroy');

           //评论话题
           $api->post('topics/{topic}/replies', 'RepliesController@store')
               ->name('api.topics.replies.store');

           // 删除回复
           $api->delete('topics/{topic}/replies/{reply}', 'RepliesController@destroy')
               ->name('api.topics.replies.destroy');


       });



   });
});



