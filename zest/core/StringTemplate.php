<?php

/**
 * StringTemplate
 * 
 * Simple way to create a template from a string
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/MaxenceCauderlier/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */
class StringTemplate extends Template
{

    /**
     * Create a template from a string
     * 
     * @param string Template content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Return the parsed template content
     * 
     * @return string Parsed content
     */
    public function output()
    {
        ob_start();
        $this->addGlobalsToVars();
        $this->parse();
        // Uncomment the next line to see parsed template
        //file_put_contents($this->file . '.cache.php', $this->content);
        eval('?>' . $this->content);
        return ob_get_clean();
    }
}