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
    protected $tpl      = [];
    
    /** @var array      Messages to display to User */
    protected $flashMsg = [];

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
     * @param \Zest\Templates\Template Template to display
     */
    public function addTemplate(\Zest\Templates\Template $template)
    {
        $this->tpl[] = $template;
    }

    /**
     * Display the response
     * 
     * @return string Content of all tpl added
     */
    public function output()
    {
        $layout  = new \Zest\Templates\Template('layout.tpl');
        $layout->set('page_title', $this->title);
        $layout  = $this->fillFlashMessages($layout);
        $content = '';
        foreach ($this->tpl as $tpl) {
            $content .= $tpl->output();
        }
        $layout->set('content', $content);
        return $layout->output();
    }

    /**
     * Add a Flash message to display at user on the page
     * Message can be seen only one time
     * 
     * @param \Zest\Utils\Message Message to display
     */
    public function addFlashMessage(\Zest\Utils\Message $message)
    {
        $this->flashMsg[$message->name] = $message;
    }

    /**
     * Fill the layout with all flash messages
     * 
     * @param \Zest\Templates\Template Layout to add the flash messages
     * @return \Zest\Templates\Template
     */
    protected function fillFlashMessages($layout)
    {
        $flashTpl = new \Zest\Templates\StringTemplate("{% for MSG in FLASH_MSG %} {{ MSG }} {% endfor %}");
        $flashTpl->set('FLASH_MSG', $this->flashMsg);
        $layout->set('FLASH_MESSAGES', $flashTpl->output());
        return $layout;
    }

}
