<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Zest\Templates;

/**
 * Description of PluginTemplate
 *
 * @author Toss
 */
class PluginTemplate extends Template
{
    public function __construct($pluginName, $file)
    {
        $site_config = \Zest\Core\Zest::getInstance()->getSiteConfig();
        $filename    = THEMES_PATH . $site_config['theme'] . DS . $pluginName . DS .'tpl' . DS . $file;
        if (is_file($filename))
        {
            $this->file = $filename;
        }
        else
        {
            $this->file = PLUGINS_PATH . $pluginName . DS . 'tpl' . DS . $file;
        }
    }
}
