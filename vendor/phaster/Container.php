<?php
/**
 * +----------------------------------------------------------------------
 * | Author     Mr. Shen <919406675@qq.com> 时间：2019/5/16 17:27
 * +----------------------------------------------------------------------
 **/


namespace lib\phaster;


use Phalcon\Config;
use Phalcon\Di\FactoryDefault;
use Phalcon\Http\Response;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;

class Container extends FactoryDefault
{
    /**
     * 用于缓存配置
     */
    protected static $app_config;

    public function __construct()
    {
        parent::__construct();
        $this->registerServices();
    }

	/**
	 * 注册所有服务
	 * author: sss
	 * date:2019/6/24 9:56
	 */
    protected function registerServices():void
    {
        $this->registerConfig();
        $this->registerRouter();
        $this->registerDispatcher();
        $this->registerView();
		$this->registerUrlResolver();
		$this->registerResponse();
    }

	/**
	 * 加载配置，便于其他访问
	 * author: sss
	 * date:2019/6/24 9:56
	 */
    public static function setAppConfig(){
        if(is_null(self::$app_config)){
            self::$app_config =new Config(include BASE_PATH . '/config/app.php');
        }
    }

	/**
	 * 注册配置
	 * author: sss
	 * date:2019/6/24 9:57
	 */
    private function registerConfig():void
    {
        self::setAppConfig();
        $this->setShared('app_config',function (){
            return self::$app_config;
        });
    }

	/**
	 * 注册路由
	 * author: sss
	 * date:2019/6/24 9:57
	 */
    private function registerRouter():void
    {
        $this->setShared('router',function (){
			return new \Phalcon\Mvc\Router();
        });
    }


    private function registerDispatcher():void
    {
        $this->setShared('dispatcher',function (){
        	return new Dispatcher();
            $router=$this->getShared('router');
            $module=$router->getModuleName();
            $controller=$router->getControllerName();
            $action=$router->getActionName();
            $dispatcher = new Dispatcher();
            $dispatcher->setModuleName($module);
            $dispatcher->setControllerName($controller);
            $dispatcher->setActionName($action);
            $dispatcher->setNamespaceName('app\\'.$module.'\\controller');
            //请求调度
            $dispatcher->setDI($this);
            $dispatcher->dispatch();
        });
    }

	/**
	 * 注册视图
	 * author: sss
	 * date:2019/6/24 9:57
	 */
    private function registerView():void {
        $di=$this;
        $this->setShared('view',function ()use($di){
            $view = new \Phalcon\Mvc\View\Simple();

            $view->setViewsDir(self::$app_config->view_dir);

            $view->registerEngines([
                '.volt' =>function($view,$di){
                    $volt = new VoltEngine($view,$di);
                    $volt->setOptions(
                        [
                            'compiledPath'      => self::$app_config->view_cache_dir,
                            'compiledSeparator' => '_',
                        ]
                    );
					return $volt;
                }
            ]);
            return $view;
        });
    }

    private function registerUrlResolver(){
        $this->setShared('url',function (){
            $url = new Url();
            $url->setBaseUri('/');
            return $url;
        });
    }

    private function registerResponse(){
		$this->setShared('response',function (){
			return new Response();
		});
	}





}