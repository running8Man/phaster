<?php
/**
 * +----------------------------------------------------------------------
 * | Author     Mr. Shen <919406675@qq.com> 时间：2019/5/16 17:27
 * +----------------------------------------------------------------------
 **/


namespace lib\phaster;

use Phalcon\Mvc\Application as PhalconApplication;
use Phalcon\Mvc\View;

class Application extends PhalconApplication
{
    private $container;


    public function __construct(Container $container)
    {
        $this->container=$container;
        $this->setDI($container);
        $this->autoRegisterModule();

    }

    public function autoRegisterModule(){
        $router=$this->container->getShared('router');

        $moduleName=$router->getModuleName();
        $container=$this->container;
        $view=new View();

        $this->registerModules([
            $moduleName => [
            	'className'=>
			],
        ]);
    }


}