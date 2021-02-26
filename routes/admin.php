<?php
$api = app('Dingo\Api\Routing\Router');
$params = [
    'middleware' => [
        'bindings',  //使用模型注入
        'serializer:array',  //如果返回的数据非列表，则去掉transformer返回数据最外面的data元素
    ],
];
$api->version('v1',$params, function($api){

    $api->group(['prefix' => 'admin'], function ($api){
        //需要登录认证的路由
        $api->group(['middleware' => 'api.auth'],function($api){
            /**
             * 用户管理
             * 资源路由，自动创建对应资源控制器默认方法路由
             * 详细路由表使用php artisan api:routes查看
             */
            //资源路由
            $api->resource('users', \App\Http\Controllers\Admin\UserController::class, [
                'only' => ['index', 'show'],  //仅使用的路由
            ]);
            //禁用|启用用户
            $api->patch('users/{user}/lock', [\App\Http\Controllers\Admin\UserController::class, 'lock']);
            //禁用|启用分类
            $api->patch('category/{category}/status', [\App\Http\Controllers\Admin\CategoryController::class, 'status']);
            /**
             * 分类管理资源路由
             */
            $api->resource('category', \App\Http\Controllers\Admin\CategoryController::class, [
                'except' => ['destroy']  //排除路由
            ]);
        });
    });
});
