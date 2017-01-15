<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Response
 *
 * @author Toss
 */
class Response
{
    protected $title;
    
    protected $tpl = [];


    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    public function addTemplate(\Template $template)
    {
        $this->tpl[] = $template;
    }
    
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
