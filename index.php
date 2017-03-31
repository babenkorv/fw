<?php

$config = include 'config/app.php';

/*------------- Autoload -------------*/
require_once 'vendor/Autoloader.php';

$autoloader = new Autoloader([]);
$autoloader->run();

/*------------- Dependency container -------------*/
$app = new vendor\App();
$app->run([]);

/*------------- Set alias -------------*/
\vendor\components\Alias::setAlias('@project',  dirname(__DIR__) . DIRECTORY_SEPARATOR . $config['project_name'] . DIRECTORY_SEPARATOR);
\vendor\components\Alias::setAlias('@pathToNotFoundPage', \vendor\components\Alias::getAlias('@project') . 'vendor' . DIRECTORY_SEPARATOR . 'defaltMessagePage' . DIRECTORY_SEPARATOR . '404.php');
\vendor\components\Alias::setAlias('@view', \vendor\components\Alias::getAlias('@project') . 'application' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR);
\vendor\components\Alias::setAlias('@web', \vendor\components\Alias::getAlias('@project') . 'application' . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR);
\vendor\components\Alias::setAlias('@config', \vendor\components\Alias::getAlias('@project') . 'config' . DIRECTORY_SEPARATOR);

/*------------- set config asset -------------*/
\vendor\components\AssetManager::setConfigAsset();
\vendor\components\AssetManager::setDefaultPath([
    'css' => \vendor\components\Alias::getAlias('@web') . 'css' . DIRECTORY_SEPARATOR,
    'js' => \vendor\components\Alias::getAlias('@web') . 'js' . DIRECTORY_SEPARATOR,
]);

/*------------- Routing -------------*/
$query = trim($_SERVER['REQUEST_URI'], '/');



\vendor\Router::add('^$', ['controller' => 'main', 'action' => 'index']);
\vendor\Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

\vendor\Router::dispatch($query);


