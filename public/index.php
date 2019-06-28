<?php
/**
 * +----------------------------------------------------------------------
 * | Author     Mr. Shen <919406675@qq.com> 时间：2019/5/16 17:27
 * +----------------------------------------------------------------------
 **/
declare(strict_types=1);
error_reporting(E_ALL);

/*
 *  Define some necessary constants
 */
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

require BASE_PATH.'/config/autoloader.php';

try{
    //$container = new \lib\phaster\Container();
    $application =new \lib\phaster\Application();
    $application->run();

}catch (Exception $e){
    echo $e->getMessage(), '<br>';
    echo nl2br(htmlentities($e->getTraceAsString()));
}



$t2 = microtime(true);
echo '<br>耗时'.round(($t2-$app_start_time)*1000,6).'ms<br>';
echo 'Now 内存: ' . round(memory_get_usage()/1024,4) . 'kb<br />';