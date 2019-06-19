<?php
namespace app\Index\controller;

use lib\phaster\Container;

class IndexController
{
    public function index(){
        //echo 'hello';
       return $this->view->render('index');
    }

    public function notfoundAction(){
        echo 'notfound...';
    }

}