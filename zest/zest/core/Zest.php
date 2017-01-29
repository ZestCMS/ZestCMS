<?php

/**
 * Zest
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/MaxenceCauderlier/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Core;

/**
 * Application class
 * It init Router class, get the configuration and run the answered Controller.
 * Finally, display the response.
 */
class Zest
{

    /**
     * Zest Instance
     * @var \self
     */
    private static $instance;
    
    /** @var array  Config */
    private $config;
    
    /** @var array Routes */
    private $routes = [];
    
    /** @var \Zest\Core\Router  Router */
    private $router;
    
    /** @var Parser */
    private $parser;
    
    /** @var \Zest\Core\Lang Lang Object */
    public $lang;

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

        $this->lang = new Lang($this->config['site']['lang']);
        
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

        $this->router->default_route(['Zest\Controllers\Errors' , 'Page404']);
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
        \Zest\Templates\Template::addGlobal('ROOT', $this->getRootUrl());
        \Zest\Templates\Template::addGlobal('LANG', $this->lang->getAllLanguagesDatas());
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true)
        {
            \Zest\Templates\Template::addGlobal('IS_ADMIN', false);
        }
        else
        {
            \Zest\Templates\Template::addGlobal('IS_ADMIN', true);
        }
    }
    
    /**
     * Show the Page 404 and stop the script
     */
    public function call404Error()
    {
        $Error = new \Zest\Controllers\Errors();
        $response = $Error->Page404();
        $this->displayResponse($response);
        exit();
    }
    
    /**
     * Get Parser to parse content
     * 
     * @return Parser
     */
    public function getParser()
    {
        if (!isset($this->parser))
        {
            $this->loadParser();
        }
        return $this->parser;
    }
    
    /**
     * Init Parser
     */
    private function loadParser()
    {
        $this->parser = new Markdown();
    }

}
