<?php
/**
 * +----------------------------------------------------------------------
 * | Author     Mr. Shen <919406675@qq.com> 时间：2019/5/16 17:27
 * +----------------------------------------------------------------------
 **/


namespace lib\phaster;


use Phalcon\Config;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;

class Container extends FactoryDefault
{
    /**
     * 用于缓存配置
     * @var
     */
    private static $app_config;

    public function __construct()
    {
        parent::__construct();
        $this->registerServices();
    }

    /*
     * 注册所有服务
     */
    private function registerServices():void
    {
        $this->registerConfig();
        $this->registerRouter();
        //$this->registerDispatcher();
        $this->registerView();
        //$this->registerUrlResolver();

    }

    /*
     * 加载配置，便于其他访问
     */
    public static function setAppConfig(){
        if(is_null(self::$app_config)){
            self::$app_config =new Config(include BASE_PATH . '/config/app.php');
        }
    }
    /*
     *  注册配置
     */
    private function registerConfig():void
    {
        self::setAppConfig();
        $this->setShared('app_config',function (){
            return self::$app_config;
        });
    }

    /*
     * 注册路由
     */
    private function registerRouter():void
    {
        $this->setShared('router',function (){
            $router=new \Phalcon\Mvc\Router();

            //强制路由模式
			if(self::$app_config->url_route_must){

			}else{
				//设置多模块路由模式
				$router->add(
					'/:module/:controller/:action/:params',
					['module' => 1, 'controller' => 2, 'action' => 3, 'params' => 4]
				);
			}

            //设置默认路由
            $router->setDefaults((array)self::$app_config->default_module);
            $router->handle();
            return $router;
        });
    }

    private function registerDispatcher():void
    {
        $this->setShared('dispatcher',function (){
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



}