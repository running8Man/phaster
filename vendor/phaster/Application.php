<?php
/**
 * +----------------------------------------------------------------------
 * | Author     Mr. Shen <919406675@qq.com> 时间：2019/5/16 17:27
 * +----------------------------------------------------------------------
 **/

namespace lib\phaster;


use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\Micro;

class Application extends Container
{

	//版本号
	const VERSION='1.0';


	public function __construct()
	{
		$this->registerServices();
		$this->dispatchRequest();
	}

	public function dispatchRequest(): void
	{
		if(self::$app_config->url_route_must){
			$this->dispatchMvc();
		}else{
			$this->dispatchMvc();
		}

	}

	/**
	 * 设置Micro实例
	 * @return Micro
	 * author: sss
	 * date:2019/6/25 14:16
	 */
	public function setMicroInstance():void
	{
		//$this->microInstance = new Micro(parent);
	}





	/**
	 * 请求调度
	 * author: sss
	 * date:2019/6/24 12:01
	 */
	public function dispatchRequest1A(): void
	{
		$app_config = $this->container->getShared('app_config');
		$router = $this->container->getShared('router');
		if ($app_config->url_route_must) {
			$this->dispatchMvc();
		} else {
			$this->dispatchMvc();

		}
		$this->notFound(function () {
			echo '<h1>not found...</h1>';
		});
	}


	/**
	 * mvc模式
	 * @param $collection
	 * @param $defaultModule
	 * author: sss
	 * date:2019/6/24 17:34
	 */
	public function dispatchMvc(): void
	{
		$dispatcher = $this->getShared('dispatcher');
		[$module, $controller, $action, $rewrite_uri] = $this->getRoutePath();
		$namespace='app\\'.$module.'\\controller';
		$dispatcher->setModuleName($module);
		$dispatcher->setControllerName($controller);
		$dispatcher->setActionName($action);
		$dispatcher->setNamespaceName($namespace);
		//请求调度
		$dispatcher->setDI($this);
		$dispatcher->dispatch();

	}

	/**
	 * 获取mvc模式下的请求路径
	 * @param $defaultModule
	 * @return array
	 * author: sss
	 * date:2019/6/24 17:34
	 */
	public function getRoutePath(): array
	{
		$router = $this->getShared('router');

		$router->add(
			'/:module/:controller/:action/:params',
			['module' => 1, 'controller' => 2, 'action' => 3, 'params' => 4]
		);
		//设置默认路由
		$router->setDefaults((array)self::$app_config->default_module);
		$router->handle();
		return [$router->getModuleName(), $router->getControllerName(), $router->getActionName(), $router->getRewriteUri()];
	}

	public function run(){
		$dispatcher = $this->get('dispatcher');

		$returnValue = $dispatcher->getReturnedValue();

		$response =$this->getShared('response');
		$response->setContent($returnValue);
		if ($response instanceof ResponseInterface) {
			// Send the response
			$response->send();
		}
	}






}