<?php

/**
 * Controller
 * 
 * Abstract Controller overide by core Controllers
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/MaxenceCauderlier/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */
abstract class Controller
{
    /**
     * Site configuration
     * @var array
     */
    protected $site_config;
    
    /**
     * Zest configuration
     * @var array
     */
    protected $zest_config;
    
    /**
     * Constructor
     * Initialize configuration in Controller
     */
    public function __construct()
    {
        $this->site_config = $this->getZest()->getSiteConfig();
        $this->zest_config = $this->getZest()->getZestConfig();
    }
    
    /**
     * Return Zest Instance
     * @return \Zest
     */
    protected function getZest()
    {
        return Zest::getInstance();
    }
}
