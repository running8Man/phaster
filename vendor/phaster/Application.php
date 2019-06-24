<?php
/**
 * +----------------------------------------------------------------------
 * | Author     Mr. Shen <919406675@qq.com> 时间：2019/5/16 17:27
 * +----------------------------------------------------------------------
 **/


namespace lib\phaster;

use Phalcon\Mvc\Micro;

class Application extends Micro
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container=$container;
        $this->dispatchRequest();
    }


	/**
	 * 请求调度
	 * author: sss
	 * date:2019/6/24 12:01
	 */
    public function dispatchRequest():void {
        $app_config=$this->container->getShared('app_config');
        $collection = new \Phalcon\Mvc\Micro\Collection();
        if($app_config->url_route_must){
        	new Router($collection,$app_config->route_files);
            //require BASE_PATH.'/routes/api.php';
        }else{
            $this->dispatchMvc($collection,(array)$app_config->default_module);
        }
        $this->mount($collection);
    }




	public function dispatchMvc($collection,$defaultModule):void {
        [$module,$controller,$action,$rewrite_uri] = $this->getRoutePath($defaultModule);
        $controllerClass='app'.'\\'.$module.'\\controller\\'.$controller;
        $collection->setHandler($controllerClass,true);
        $collection->get($rewrite_uri,$action);
        $this->mount($collection);
    }

    public function getRoutePath($defaultModule):array {
        $router=$this->container->getShared('router');
        $router->add(
            '/:module/:controller/:action/:params',
            ['module' => 1, 'controller' => 2, 'action' => 3, 'params' => 4]
        );
        //设置默认路由
        $router->setDefaults($defaultModule);
        $router->handle();
        return [$router->getModuleName(),$router->getControllerName(),$router->getActionName(),$router->getRewriteUri()];
    }




}