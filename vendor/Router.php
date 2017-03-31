<?php
/**
 * Created by PhpStorm.
 * User: rbabenko
 * Date: 03.02.2017
 * Time: 13:27
 */

namespace vendor;

use vendor\components\Alias;

class Router
{
    public static $routes = [

    ];
    public static $route = [];

    /**
     * Add new rule.
     *
     * @param string $regexp
     * @param array $route contain controller and action name.
     */
    public static function add($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    /**
     * Transform input string to camel case format.
     *
     * @param $str
     * @return mixed
     */
    public static function upperCamelCase($str)
    {
        $str = str_replace('-', ' ', $str);
        $str = ucwords($str);
        $str = str_replace(' ', '', $str);
        return $str;
    }

    /**
     * Check url address on coincidence with set rule.
     *
     * @param string $url url address.
     * @return bool
     */
    public static function matchRoutes($url)
    {

        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#$pattern#i", $url, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                    if (empty($route['action'])) {
                        $route['action'] = 'index';
                    }
                }
                self::$route = $route;
                return true;
            }
        }

        return false;
    }

    /**
     * Parse url address and redirect on needed controller and action.
     *
     * @param $url
     */
    public static function dispatch($url)
    {

        unset($_GET['index_php']);
        unset($_GET[$_SERVER['REDIRECT_QUERY_STRING']]);

        $url = explode('?', $url)[0];
        if (self::matchRoutes($url)) {

            $controller = 'application\controller\\' . self::upperCamelCase(self::$route['controller']) . 'Controller';
       
            if (class_exists($controller)) {

                $controller = new $controller(self::$route);
                $action = 'action' . self::upperCamelCase(self::$route['action']);
                if (method_exists($controller, $action)) {
                    $controller->$action();
                } else {
                    $message = 'Controller : ' . self::upperCamelCase(self::$route['controller']) . 'Controller' . '<br>' . 'action : ' . $action . ' is not fund';
                    include Alias::getAlias('@pathToNotFoundPage');
                }
            } else {
                $message = 'Controller : ' . self::upperCamelCase(self::$route['controller']) . 'Controller is not fund';
                include Alias::getAlias('@pathToNotFoundPage');
            }
        } else {
            $message = 'Page not found';
            include Alias::getAlias('@pathToNotFoundPage');
        }
    }
}