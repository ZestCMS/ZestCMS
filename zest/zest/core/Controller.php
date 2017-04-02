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
     * Config Object
     * @var \Zest\Core\Configuration
     */
    protected $config;

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
        $this->config = & $this->getZest()->config;
        $this->lang   = & $this->getZest()->lang;
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
