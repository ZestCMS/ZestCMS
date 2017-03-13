<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Zest\Core;

/**
 * Description of Plugin
 *
 * @author Toss
 */
class Plugin
{

    protected $pluginName;
    protected $pluginPath;
    protected $options = [];
    protected $routes = [];

    public function __construct($pluginName, $values = [])
    {
        $this->pluginName = $pluginName;
        $this->pluginPath = PLUGINS_PATH . $pluginName . DS;

        foreach ($values as $key => $value) {
            $this->options[$key] = $value;
        }
    }

    public function load()
    {
        $this->loadRoutes();
        require_once $this->pluginPath . $this->pluginName . '.php';
    }

    protected function loadRoutes()
    {
        if (file_exists($this->pluginPath . 'routes.php')) {
            $this->routes = require $this->pluginPath . 'routes.php';
        }
    }

    public function getName()
    {
        return $this->pluginName;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getLanguagePath()
    {
        return $this->pluginPath . 'lang' . DS;
    }

}
