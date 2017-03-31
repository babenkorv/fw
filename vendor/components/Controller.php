<?php
/**
 * Created by PhpStorm.
 * User: rbabenko
 * Date: 03.02.2017
 * Time: 15:46
 */

namespace vendor\components;


class Controller
{
    private $view;
    private $controller;
    public $viewUniqueName = '';
    public $layout = 'main';

    public function __construct($route)
    {
        session_start();
        $this->view = $route['action'];
        $this->controller = $route['controller'];
        $this->viewUniqueName = $this->setViewUniqueName();

        foreach ($_GET as $key => $value) {
            if(!empty($value)) {
                $this->param[$key] = $value;
            }
        }

        unset($_GET['index_php']);
        unset($_GET[$this->controller]);
    }

    public function setViewUniqueName()
    {
        return $this->controller . '::' . $this->view;
    }

    public function render($view, $params = [])
    {
        $assets = '';
        $pathToLayout = Alias::getAlias('@view') . 'layout' . DIRECTORY_SEPARATOR . $this->layout . '.php';
        $pathToView = Alias::getAlias('@view') . $this->controller . DIRECTORY_SEPARATOR . $view . '.php';
        if(!empty($params)) {
            foreach ($params as $paramKey => $paramValue) {
                ${$paramKey} = $paramValue;
            }
        }

        if(file_exists($pathToView)) {

            ob_start();
       
            include ($pathToView);

            $content = ob_get_contents();
            ob_end_clean();
            if(file_exists($pathToLayout)) {
                include $pathToLayout;
            } else {
                $message = 'layout not found';
                include Alias::getAlias('@pathToNotFoundPage');
            }

        } else {
            $message = 'view not found';
            include Alias::getAlias('@pathToNotFoundPage');
        }
    }
    
    public function redirectToUrl($url) 
    {
        header('Location: ' . $url);
    }
    
}