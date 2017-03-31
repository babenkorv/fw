<?php

namespace vendor\components;


class AssetManager
{
    private static $assets = [];

    private static $includedLink = [];

    private static $defaultPath = [];

    /**
     * Return asset with name @param $name .
     *
     * @param string $name unique asset name.
     * @return mixed
     * @throws \Exception
     */
    public static function getAsset($name)
    {
        if (!empty(self::$assets[$name])) {
            throw new \Exception('Asset with name: ' . $name . ' not found');
        }

        return self::$assets[$name];
    }

    /**
     * Add new asset to asset array.
     *
     * @param string $name unique name view.
     * @param array $assets array with assets files.
     */
    public function setAsset($name, $assets)
    {

        foreach ($assets as $type => $asset) {
            if (array_key_exists($type, self::$assets)) {
                if (array_key_exists($name, self::$assets[$type])) {
                    foreach ($asset as $item) {
                        if (!in_array($item, self::$assets[$type][$name])) {
                            array_push(self::$assets[$type][$name], $item);
                        }
                    }
                } else {
                    self::$assets[$type][$name] = $asset;
                }
            }
        }
    }

    /**
     * Include files that are contained in an asses array on view.
     *
     * Example @param $defaultPath : nameController::nameView.
     *
     * @param string $unique unique view name.
     * @param array $defaultPath this property change default path to css, js files.
     */
    public static function register($unique, $defaultPath = [])
    {
        $currentPageRequestUri = str_replace('/', '::', substr($_SERVER['REQUEST_URI'], 1, strlen($_SERVER['REQUEST_URI'])));

        $assetCss = array_merge(
            (!empty(self::$assets['css']['*'])) ? self::$assets['css']['*'] : [],
            (!empty(self::$assets['css'][$unique])) ? self::$assets['css'][$unique] : []);
        $assetJs = array_merge(
            (!empty(self::$assets['js']['*'])) ? self::$assets['js']['*'] : [],
            (!empty(self::$assets['js'][$unique])) ? self::$assets['js'][$unique] : []);

        if (!isset(self::$includedLink[$currentPageRequestUri])) {
            self::$includedLink[$currentPageRequestUri] = [];
        }
        ob_start();
        foreach ($assetCss as $key => $css) {
            self::$includedLink[$currentPageRequestUri][] = $css;
            echo '<link href="' . '/application/web/' . $css . '"  rel="stylesheet">' . PHP_EOL;
        }
        $htmlLink = ob_get_contents();
        ob_end_clean();

        ob_start();
        foreach ($assetJs as $key => $js) {
            self::$includedLink[$currentPageRequestUri][] = $js;
            echo '<script src="' . '/application/web/' . 'js/' . $js . '">' . '</script>' . '<br>';

        }
        $jsScript = ob_get_contents();
        ob_end_clean();
        return ['html' => $htmlLink, 'js' => $jsScript];
    }

    /**
     * Set path to folder with js, css files.
     *
     * For example @param array $defaultPath :
     *      [
     *          'css' => [
     *              'path/to/css/files'
     *          ],
     *          'js' => [
     *              'path/to/js/files'
     *          ]
     *      ]
     *
     * @param array $defaultPath path to css and js files.
     */
    public static function setDefaultPath($defaultPath)
    {
        self::$defaultPath = $defaultPath;
    }

    /**
     * Sets assets array equal with array in config file.
     */
    public static function setConfigAsset()
    {
        $configAsset = include(Alias::getAlias('@config') . 'app.php');
        self::$assets = $configAsset['assetManager'];
    }
}