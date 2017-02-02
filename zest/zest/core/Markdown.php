<?php

/**
 * Markdown
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Core;

/**
 * Markdown is a simple class who interface between Zest and ParsedownExtra
 */

class Markdown
{
    /** @var \ParsedownExtra ParsedownExtra Instance */
    private $parsedown;
    
    /**
     * Load libraries and create new Parser instance
     */
    public function __construct()
    {
        require_once CORE_PATH . 'libs' . DS . 'Parsedown.php';
        require_once CORE_PATH . 'libs' . DS . 'ParsedownExtra.php';
        $this->parsedown = new \ParsedownExtra();
    }
    
    /**
     * Parse Content
     * 
     * @param  string    Content to parse
     * @return string    Parsed Content
     */
    public function parse($content)
    {
        return $this->parsedown->text($content);
    }
}
