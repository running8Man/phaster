<?php
/**
 * +----------------------------------------------------------------------
 * | Author     Mr. Shen <919406675@qq.com> 时间：2019/5/16 17:27
 * +----------------------------------------------------------------------
 **/


namespace lib\phaster;

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\View;

class Application extends Micro
{
    private $container;


    public function __construct(Container $container)
    {
        $this->container=$container;
        $this->dispatchRoute();
    }


	public function dispatchRoute(){
        [$module,$controller,$action,$rewrite_uri] = $this->getRoutePath();
        $controllerClass='app'.'\\'.$module.'\\controller\\'.$controller;
        $collection = new \Phalcon\Mvc\Micro\Collection();
        $collection->setHandler($controllerClass,true);
        $collection->get($rewrite_uri,$action);
        $this->mount($collection);
    }

    public function getRoutePath(){
        $router=$this->container->getShared('router');
        return [$router->getModuleName(),$router->getControllerName(),$router->getActionName(),$router->getRewriteUri()];
    }




}