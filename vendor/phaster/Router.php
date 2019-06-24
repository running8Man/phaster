<?php
/**
 * +----------------------------------------------------------------------
 * | Author     Mr. Shen <919406675@qq.com> 时间：2019/5/16 17:27
 * +----------------------------------------------------------------------
 **/


namespace lib\phaster;



use Phalcon\Loader;

class Router
{
    protected static $router;

    protected static $routeFiles;

    public function __construct($router,$routeFiles)
	{
		self::$router=$router;
		self::$routeFiles=$routeFiles;
		$this->registerRouterDirs();
	}

	public function registerRouterDirs(){
    	$loader= new Loader();
		$routeFiles=$this->getRouteFiles();
		$router=self::$router;
		$loader->registerFiles($routeFiles,true);
		$loader->register();
	}

	public function getRouteFiles(){
		$routeFileArray=[];
		$path =BASE_PATH.'/routes/';
		foreach (self::$routeFiles as $v){
			$routeFileArray[]=$path.$v.'.php';
		}
		return $routeFileArray;

	}


}