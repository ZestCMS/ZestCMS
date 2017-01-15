<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Zest
 *
 * @author Toss
 */
class Zest
{

    private static $instance;
    private $config;
    private $routes = [];
    private $router;

    public static function getInstance()
    {
        if (!isset(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->config = parse_ini_file(CORE_PATH . 'config.ini', true);

        $this->initRouter();
    }

    public function run()
    {
        foreach ($this->routes as $pattern => $callback)
        {
            $this->router->route($pattern, $callback);
        }

        $response = $this->router->execute();

        $this->displayResponse($response);
    }

    public function getSiteConfig()
    {
        return $this->config['site'];
    }
    
    public function getZestConfig()
    {
        return $this->config['zest'];
    }

    public function getRootUrl()
    {
        return $this->config['zest']['url'];
    }

    private function initRouter()
    {
        $this->router = new Router();

        $this->router->default_route(['Page404Controller' , 'error404']);
        $this->routes = require CORE_PATH . 'routes.php';
    }

    private function displayResponse($response)
    {
        $response->output();
    }

}
