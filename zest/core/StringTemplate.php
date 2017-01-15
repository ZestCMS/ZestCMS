<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Template
 *
 * @author Toss
 */
class StringTemplate extends Template
{
    
    protected $content;
    protected $data = [];

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function output()
    {
        
        $this->content       = str_replace("{{ROOT}}", Zest::getInstance()->getRootUrl(), $this->content);
        foreach ($this->data as $key => $value)
        {
            $tagToReplace = "{{" . $key . "}}";
            $output       = str_replace($tagToReplace, $value, $this->content);
        }

        return $this->content;
    }

}
