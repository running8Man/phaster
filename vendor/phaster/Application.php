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
        $this->setDI($container);
        //$this->autoRegisterModule();
		//$this->dispatchRoute();

    }

    public function handle($uri = null)
	{
		parent::handle($uri);
	}

	public function dispatchRoute(){
        $router=$this->container->getShared('router');
        $moduleName=$router->getModuleName();
        $controller=$router->getControllerName();
        $action=$router->getActionName();
        print_r([
			'module' => $moduleName,
			'controller' => $controller,
			'action'     => $action,
		]);
		$router->add(
			'Index',
			[
				'module' => $moduleName,
				'controller' => $controller,
				'action'     => $action,
			]
		);
		$router->handle();
        //$container=$this->container;
        //$view=new View();

//        $this->registerModules([
//            $moduleName => [
//            	'className'=>
//			],
//        ]);
    }


}