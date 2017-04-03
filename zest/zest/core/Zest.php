<?php

/**
 * Zest
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
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

    /** @var \Zest\Core\Configuration Config Object */
    public $config;

    /** @var array Routes */
    private $routes = [];

    /** @var \Zest\Core\Router  Router */
    private $router;

    /** @var Parser */
    private $parser;

    /** @var \Zest\Core\PluginsManager PluginsManager */
    private $pluginsManager;

    /** @var \Zest\Core\Lang Lang Object */
    public $lang;
    private $flashMessages = [];

    /**
     * Return Zest Instance
     * @return \self
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        session_start();
        $this->flushFlashMessages();
        $this->config = new Configuration();
        define('ROOT_URL', $this->config->get('zest', 'url'));

        $this->lang = new Lang($this->config->get('site', 'lang'));

        $this->initRouter();

        $this->pluginsManager = new PluginsManager(PLUGINS_PATH);
        $this->pluginsManager->loadPlugins();

        foreach ($this->pluginsManager->getLanguagesPaths() as $path) {
            $this->lang->loadPluginFile($path);
        }
        $this->initGlobals();
    }

    /**
     * Run the framework
     * Test all routes, run a controller and display returned response
     */
    public function run()
    {
        // Core routes
        $this->router->addLotOfRoutes($this->routes);

        // Plugins routes
        foreach ($this->pluginsManager->getPluginsRoutes() as $plugin) {
            $this->router->addLotOfRoutes($plugin);
        }

        $response = $this->router->execute();

        $this->displayResponse($response);
    }

    /**
     * Get PluginsManager
     *
     * @return \Zest\Core\PluginsManager
     */
    public function getPluginsManager()
    {
        return $this->pluginsManager;
    }

    /**
     * Initialize Router, load routes and define the defaut_route,
     * used if no route is matching the requested URI
     */
    private function initRouter()
    {
        $this->router = new Router();

        $this->router->default_route(['Zest\Controllers\Errors', 'Page404']);
        $this->routes = require CORE_PATH . 'routes.php';
    }

    /**
     * Display the response returned by controller
     */
    private function displayResponse($response)
    {
        foreach ($this->flashMessages as $msg) {
            $response->addFlashMessage($msg);
        }
        echo $response->output();
    }

    /**
     * Add all site and framework globals to the templates
     */
    private function initGlobals()
    {
        \Zest\Templates\Template::addGlobal('ROOT', $this->config->get('zest', 'url'));
        \Zest\Templates\Template::addGlobal('THEME', $this->config->get('site', 'theme'));
        \Zest\Templates\Template::addGlobal('SITENAME', $this->config->get('site', 'title'));
        \Zest\Templates\Template::addGlobal('LANG', $this->lang->getAllLanguagesDatas());
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
            \Zest\Templates\Template::addGlobal('IS_ADMIN', false);
        }
        else {
            \Zest\Templates\Template::addGlobal('IS_ADMIN', true);
        }
    }

    /**
     * Show the Page 404 and stop the script
     */
    public function call404Error()
    {
        $Error    = new \Zest\Controllers\Errors();
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
        if (!isset($this->parser)) {
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

    public function redirect($url)
    {
        header('Location:' . $url);
        exit();
    }

    public function getSiteTitle()
    {
        return $this->config->get('site', 'title');
    }

    public function addFlashMsg($class, $content, $closable = true)
    {
        if (!isset($_SESSION['flash_msg']) || !is_array($_SESSION['flash_msg'])) {
            $_SESSION['flash_msg'] = [];
        }
        $_SESSION['flash_msg'][] = [
            'class'    => $class,
            'content'  => $content,
            'closable' => $closable
        ];
    }

    private function flushFlashMessages()
    {
        if (!isset($_SESSION['flash_msg']) || !is_array($_SESSION['flash_msg'])) {
            return;
        }
        foreach ($_SESSION['flash_msg'] as $msg) {
            $this->flashMessages[] = new \Zest\Utils\Message(uniqid(), $msg['class'], $msg['content'], $msg['closable']);
        }
        unset($_SESSION['flash_msg']);
    }

}
