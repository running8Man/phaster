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
        $requestPath = $this->getRoutePath();
        $controllerClass='app'.'\\'.$requestPath['module'].'\\controller\\'.$requestPath['controller'];
        var_dump($requestPath['module']);
        $collection = new \Phalcon\Mvc\Micro\Collection();
        $collection->setHandler($controllerClass,true);
        $collection->get('/Index',$requestPath['action']);
        $this->mount($collection);
    }

    public function getRoutePath(){
        $router=$this->container->getShared('router');
        return ['module'=>$router->getModuleName(), 'controller'=>$router->getControllerName(),'action'=>$router->getActionName()];
    }




}