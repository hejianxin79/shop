<?php
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function($api){
    //路由组
    $api->group(['prefix'=>'auth'], function($api){
        // /api/auth/register
        $api->post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'store']);
        /*
         * 用户登录路由
         *  /api/auth/login
         */
        $api->post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
        //需要登录认证的路由
        $api->group(['middleware' => 'api.auth'],function($api){
            //退出登录
            $api->post('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout']);
            //刷新token
            $api->post('refresh', [\App\Http\Controllers\Auth\LoginController::class, 'refresh']);
        });
    });

});
