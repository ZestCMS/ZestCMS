<?php

/**
 * Zest
 * 
 * Application class
 * It init Router class, get the configuration and run the answered Controller.
 * Finally, display the response.
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/MaxenceCauderlier/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */
class Zest
{

    /**
     * Zest Instance
     * @var \self
     */
    private static $instance;
    private $config;
    private $routes = [];
    private $router;

    /**
     * Return Zest Instance
     * @return \self
     */
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
