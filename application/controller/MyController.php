<?php

namespace application\controller;

use application\models\MyModel;
use vendor\components\Controller;
use vendor\widgets\GridView;

class MyController extends Controller
{
   public $layout = 'main';

    public function actionIndex()
    {
        
        $this->render('index', []);
    }
}