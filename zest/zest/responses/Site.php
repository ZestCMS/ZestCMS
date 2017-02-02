<?php

/**
 * Site
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Responses;

/**
 * Container to inject templates
 * When Response is returned on Zest class, output() is called
 */
class Site
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
    public function addTemplate(\Zest\Templates\Template $template)
    {
        $this->tpl[] = $template;
    }
    
    /**
     * Display the response
     */
    public function output()
    {
        $site_config = \Zest\Core\Zest::getInstance()->getSiteConfig();
        $layout = new \Zest\Templates\Template('layout.tpl');
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
