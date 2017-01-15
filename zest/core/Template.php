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
class Template
{
    
    protected $file;
    protected $data = [];

    public function __construct($file)
    {
        $site_config = Zest::getInstance()->getSiteConfig();
        $filename = THEMES_PATH . $site_config['theme'] . DS . $file;
        if (is_file($filename))
        {
            $this->file = $filename;
        }
        else
        {
            $this->file = THEMES_PATH . 'default' . DS . $file;
        }
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function output()
    {
        if (!file_exists($this->file))
        {
            return "Error loading template file ($this->file).";
        }
        $output = file_get_contents($this->file);
        
        $output       = str_replace("{{ROOT}}", Zest::getInstance()->getRootUrl(), $output);
        foreach ($this->data as $key => $value)
        {
            $tagToReplace = "{{" . $key . "}}";
            $output       = str_replace($tagToReplace, $value, $output);
        }

        return $output;
    }

}
