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
        session_start();
        $this->config = parse_ini_file(CORE_PATH . 'config.ini', true);

        $this->initRouter();
        $this->initGlobals();
    }

    /**
     * Run the framework
     * Test all routes, run a controller and display returned response
     */
    public function run()
    {
        foreach ($this->routes as $pattern => $callback)
        {
            $this->router->route($pattern, $callback);
        }

        $response = $this->router->execute();

        $this->displayResponse($response);
    }

    /**
     * Get the site config as array
     * 
     * @return array
     */
    public function getSiteConfig()
    {
        return $this->config['site'];
    }
    
    /**
     * Get the framework config as array
     * 
     * @return array
     */
    public function getZestConfig()
    {
        return $this->config['zest'];
    }

    /**
     * Get the site root url, defined in config.ini
     * 
     * @return string Url
     */
    public function getRootUrl()
    {
        return $this->config['zest']['url'];
    }    

    /**
     * Initialize Router, load routes and define the defaut_route,
     * used if no route is matching the requested URI
     */
    private function initRouter()
    {
        $this->router = new Router();

        $this->router->default_route(['Page404Controller' , 'error404']);
        $this->routes = require CORE_PATH . 'routes.php';
    }

    /**
     * Display the response returned by controller
     */
    private function displayResponse($response)
    {
        $response->output();
    }
    
    /**
     * Add all site and framework globals to the templates
     */
    private function initGlobals()
    {
        Template::addGlobal('ROOT', $this->getRootUrl());
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true)
        {
            Template::addGlobal('IS_ADMIN', false);
        }
        else
        {
            Template::addGlobal('IS_ADMIN', true);
        }
    }
    
    /**
     * Show the Page 404 and stop the script
     */
    public function call404Error()
    {
        $Error = new Page404Controller();
        $response = $Error->error404();
        $this->displayResponse($response);
        exit();
    }

}
