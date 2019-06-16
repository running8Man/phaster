<?php
namespace app\Index\controller;

use lib\phaster\Container;

class IndexController
{
    public function indexAction(){
        echo 'hello';
       //return $this->view->render('index','index');
    }

    public function notfoundAction(){
        echo 'notfound...';
    }

}