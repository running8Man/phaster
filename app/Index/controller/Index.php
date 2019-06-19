<?php
namespace app\Index\controller;

use lib\phaster\Controller;

class Index extends Controller
{
    public function index(){
       return $this->view->render('index');
    }

    public function notfoundAction(){
        echo 'notfound...';
    }

}