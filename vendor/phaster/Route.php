<?php
/**
 * +----------------------------------------------------------------------
 * | Author     Mr. Shen <919406675@qq.com> 时间：2019/5/16 17:27
 * +----------------------------------------------------------------------
 **/


namespace lib\phaster;



use Phalcon\Loader;

class Route
{
    protected static $router;

    protected static $routeFiles;

    public function __construct($router,$routeFiles)
	{
		self::$router=$router;
		self::$routeFiles=$routeFiles;
		$this->registerRouterFiles();
	}


	/**
	 * 注册路由文件，支持多个
	 * author: sss
	 * date:2019/6/24 15:24
	 */
	public function registerRouterFiles():void {
    	$loader= new Loader();
		$routeFiles=$this->getRouteFiles();
		$loader->registerFiles($routeFiles,true);
		$loader->register();
	}


	/**
	 * 获取要加载的路由问卷
	 * @return array
	 * author: sss
	 * date:2019/6/24 15:24
	 */
	public function getRouteFiles():array {
		$routeFileArray=[];
		$path =BASE_PATH.'/routes/';
		foreach (self::$routeFiles as $v){
			$routeFileArray[]=$path.$v.'.php';
		}
		return $routeFileArray;

	}

	public static function resolvePath(string $path){
		return explode('@',$path);
	}

	public static function get(string $pattern, $func){
		self::$router->add($pattern,$func);
		self::$router->handle();
		echo self::$router->getControllerName();
	}

	public static function get1(string $pattern, string $path)
	{
		[$module,$controller,$action]=self::resolvePath($path);
		$className='app\\'.$module.'\\controller\\'.$controller;
		self::$router->setHandler(new $className);
		self::$router->get($pattern,$action);
	}




}