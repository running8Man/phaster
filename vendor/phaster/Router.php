<?php
/**
 * +----------------------------------------------------------------------
 * | Author     Mr. Shen <919406675@qq.com> 时间：2019/5/16 17:27
 * +----------------------------------------------------------------------
 **/


namespace lib\phaster;


class Router
{
    protected static $router;

    public static function getRouterInstance(){
        if(is_null(self::$router)){
            self::$router = new \Phalcon\Mvc\Router();
        }
        return self::$router;
    }

    public static function get($pattern, $paths=null){
        self::$router->addGet();
    }




}