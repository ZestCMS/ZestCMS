<?php

/**
 * Controller
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Core;

/**
 * Abstract Controller overide by core Controllers
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
     * Language Object
     * @var \Zest\Core\Lang
     */
    protected $lang;
    
    /**
     * Constructor
     * Initialize configuration in Controller
     */
    public function __construct()
    {
        $this->site_config = $this->getZest()->getSiteConfig();
        $this->zest_config = $this->getZest()->getZestConfig();
        $this->lang = $this->getZest()->lang;
    }
    
    /**
     * Return Zest Instance
     * @return \Zest\Core\Zest
     */
    protected function getZest()
    {
        return Zest::getInstance();
    }
}
