<?php
/**
 * +----------------------------------------------------------------------
 * | Author     Mr. Shen <919406675@qq.com> 时间：2019/6/19 13:31
 * +----------------------------------------------------------------------
 **/
$router =$collection;
$router->setHandler(new \app\Index\controller\Index());
$router->get('/aa', 'rest');