<?php
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function($api){

    //需要登录认证的路由
    $api->group(['middleware' => 'api.auth'],function($api){

    });
});
