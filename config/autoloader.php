<?php
/**
 * +----------------------------------------------------------------------
 * | Author     Mr. Shen <919406675@qq.com> time：2019/5/16 17:27
 * +----------------------------------------------------------------------
 **/
/*
 * register loader 注册自动加载器
 */
$app_start_time = microtime(true);

$loader = new \Phalcon\Loader();

$loader->registerNamespaces([
    'lib' => BASE_PATH . '\\vendor',
    'app'         => APP_PATH,
]);

$loader->register();