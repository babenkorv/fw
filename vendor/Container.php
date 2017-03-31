<?php

namespace vendor;


use vendor\components\AssetManager;
use vendor\log\Logger;
use vendor\psr7\HttpRequest;
use vendor\psr7\HttpResponse;

class Container
{
    private $components;
    private $classes;

    public function __construct(array $config = [])
    {
        $this->components = new \stdClass();
        $this->setDefaultClasses();
    }

    public function __get($className)
    {


        if (isset($this->components->{$className})) {
            return $this->components->{$className};
        }



        if(!class_exists($this->classes->{$className}) && !class_exists($className)) {
            throw new \Exception ("Class $className is not exist");
        }

        if(method_exists($this->classes->{$className}, '__construct')) {
            $refMethod = new \ReflectionMethod($this->classes->{$className}, '__construct');
            $params = $refMethod->getParameters();

            $re_args = [];
            foreach ($params as $key => $param) {
                if($param->isDefaultValueAvailable()) {
                    $re_args[$param->name] = $param->getDefaultValue();
                } else {
                    $class = $param->getClass();

                    if ($class !== null) {
                        $re_args[$param->name] = $this->{$class->name};
                    } else {
                        throw new \Exception($class->name . 'not found in container');
                    }
                }
            }

            $refClass = new \ReflectionClass($this->classes->{$className});
            $class_instance = $refClass->newInstanceArgs((array)$re_args);
        } else {
            $class_instance = new $className();
        }

        return $this->components->{$className} = $class_instance;
    }

    private function setDefaultClasses(array $config = [])
    {
        $this->classes = (object)array_merge($this->getDefaultClasses(), $config);
    }

    private function getDefaultClasses()
    {
        return [
            'HttpRequest' => HttpRequest::class,
            'HttpResponse' => HttpResponse::class,
            'Logger' => Logger::class,
            'AssetManager' => AssetManager::class,
        ];
    }
}