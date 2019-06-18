<?php
/**
 * +----------------------------------------------------------------------
 * | Author     Mr. Shen <919406675@qq.com> 时间：2019/5/16 17:27
 * +----------------------------------------------------------------------
 **/
return [
    //强制路由模式
    'force_route'    => true,

    //日志目录
    'log_dir'        => BASE_PATH . 'storage/logs',

    //视图目录
    'view_dir'       => BASE_PATH . 'resources/',

    //视图缓存目录
    'view_cache_dir'       => BASE_PATH . 'storage/framework/views',

    //命名空间所在目录
    'namespace'      => [
        'app'        => 'app/',
        'Faster\lib' => '/vendor',
    ],

    //默认模块
    'default_module' => [
        "module"     => "Index",
        "controller" => "Index",
        "action"     => "index",
    ],

    //404路由
    'not_found'      => [
        "module"     => "Index",
        "controller" => "Index",
        "action"     => "notfound",
    ]


];