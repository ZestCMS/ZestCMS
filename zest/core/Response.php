<?php

/**
 * Response
 * 
 * Container to inject templates
 * When Response is returned on Zest class, output() is called
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/MaxenceCauderlier/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */
class Response
{
    /** @var string     Page title */
    protected $title;
    
    /** @var array      Templates collection to display */
    protected $tpl = [];

    /**
     * Set the page title
     * 
     * @param string Page title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * Add a template to the collection to display
     * 
     * @param \Template Template to display
     */
    public function addTemplate(\Template $template)
    {
        $this->tpl[] = $template;
    }
    
    /**
     * Display the response
     */
    public function output()
    {
        $site_config = Zest::getInstance()->getSiteConfig();
        $layout = new Template('layout.tpl');
        $layout->set('page_title', $this->title);
        $layout->set('site_name', $site_config['title']);
        $content = '';
        foreach ($this->tpl as $tpl)
        {
            $content .= $tpl->output();
        }
        $layout->set('content', $content);
        echo $layout->output();
    }
}
