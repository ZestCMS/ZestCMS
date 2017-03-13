<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Zest\Core;

/**
 * Description of PluginsManager
 *
 * @author Toss
 */
class PluginsManager
{

    protected $installedPlugins = [];

    public function __construct()
    {
        $pluginsJson = json_decode(file_get_contents(PLUGINS_PATH . 'plugins.json'), true);
        foreach ($pluginsJson as $pluginName => $values) {
            if ($values['active'] === true) {
                $this->installedPlugins[$pluginName] = new Plugin($pluginName, $values);
            }
        }
    }

    public function searchPlugins()
    {
        $dirsPlugins = array_filter(glob(PLUGINS_PATH . '*'), 'is_dir');
        foreach ($dirsPlugins as $dir) {
            $parts         = explode(DS, $dir);
            $pluginDirName = $parts[count($parts) - 1];
            $plugin        = new Plugin($dir);
            if ($plugin->isValid()) {
                $this->plugins[$pluginDirName] = & $plugin;
            }
        }
    }

    public function loadPlugins()
    {
        foreach ($this->installedPlugins as $plugin) {
            $plugin->load();
        }
    }

    public function getPluginsRoutes()
    {
        $routes = [];
        foreach ($this->installedPlugins as $plugin) {
            $routes[$plugin->getName()] = $plugin->getRoutes();
        }
        return $routes;
    }

    public function getLanguagesPaths()
    {
        $paths = [];
        foreach ($this->installedPlugins as $plugin) {
            $paths[] = $plugin->getLanguagePath();
        }
        return $paths;
    }

}
