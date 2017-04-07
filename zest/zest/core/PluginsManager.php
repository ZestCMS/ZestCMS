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

    /**
     * JSON File
     */
    const FILE = 'plugins.json';

    protected static $installedPlugins = [];
    protected static $plugins          = [];

    public function __construct()
    {
        $pluginsJson = self::getPluginsMetas();
        foreach ($pluginsJson as $pluginName => $values) {
            self::$installedPlugins[$pluginName] = new Plugin($pluginName, $values);
        }
    }

    public static function getInstalledPlugins()
    {
        return self::$installedPlugins;
    }

    public static function disablePlugin($pluginName)
    {
        if (isset(self::$installedPlugins[$pluginName])) {
            self::$installedPlugins[$pluginName]->disable();
            self::saveJsonFile();
            return true;
        }
        return false;
    }

    public static function enablePlugin($pluginName)
    {
        if (isset(self::$installedPlugins[$pluginName])) {
            self::$installedPlugins[$pluginName]->enable();
            self::saveJsonFile();
            return true;
        }
        return false;
    }

    public static function installPlugin($pluginName)
    {
        $installFile = PLUGINS_PATH . $pluginName . DS . 'install.php';
        if (is_file($installFile)) {
            include $installFile;
        }

        self::$installedPlugins[$pluginName] = new Plugin($pluginName, ['active' => true]);
        self::saveJsonFile();
        return true;
    }

    public static function uninstallPlugin($pluginName)
    {
        $uninstallFile = PLUGINS_PATH . $pluginName . DS . 'uninstall.php';
        if (is_file($uninstallFile)) {
            include $uninstallFile;
        }

        unset(self::$installedPlugins[$pluginName]);
        var_dump(self::$installedPlugins);
        self::saveJsonFile();
        return true;
    }

    public static function isInstalledPlugin($pluginName)
    {
        return isset(self::$installedPlugins[$pluginName]);
    }

    /**
     * Get all Plugins Metas as an associative array, where key is plugin dirname
     *
     * @return array
     */
    public static function getPluginsMetas()
    {
        return json_decode(file_get_contents(PLUGINS_PATH . self::FILE), true);
    }

    /**
     * Save JSON Plugins File
     *
     * @return bool
     */
    protected static function saveJsonFile()
    {
        return file_put_contents(PLUGINS_PATH . self::FILE, json_encode(self::$installedPlugins, JSON_NUMERIC_CHECK + JSON_PRETTY_PRINT));
    }

    public static function searchPlugins()
    {
        if (!empty(self::$plugins)) {
            // Already called
            return self::$plugins;
        }
        $dirsPlugins = array_filter(glob(PLUGINS_PATH . '*'), 'is_dir');

        $metas = self::getPluginsMetas();
        foreach ($dirsPlugins as $dir) {
            $parts         = explode(DS, $dir);
            $pluginDirName = $parts[count($parts) - 1];
            if (isset($metas[$pluginDirName])) {
                // Plugin is installed
                $plugin = new Plugin($pluginDirName, $metas[$pluginDirName]);
            }
            else {
                $plugin = new Plugin($pluginDirName);
            }

            if ($plugin->isValid()) {
                $plugin->setInfosFromIniFile();
                self::$plugins[$pluginDirName] = $plugin;
            }
        }
        return self::$plugins;
    }

    public function loadPlugins()
    {
        foreach (self::$installedPlugins as $plugin) {
            if ($plugin->isActive()) {
                $plugin->load();
            }
        }
    }

    public function getPluginsRoutes()
    {
        $routes = [];
        foreach (self::$installedPlugins as $plugin) {
            if ($plugin->isActive()) {
                $routes[$plugin->getName()] = $plugin->getRoutes();
            }
        }
        return $routes;
    }

    public function getLanguagesPaths()
    {
        $paths = [];
        foreach (self::$installedPlugins as $plugin) {
            if ($plugin->isActive()) {
                $paths[] = $plugin->getLanguagePath();
            }
        }
        return $paths;
    }

}
