<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Zest\Core;

/**
 * Description of Plugin
 *
 * @author Toss
 */
class Plugin implements \JsonSerializable
{

    public $name;
    public $author;
    public $author_mail;
    public $author_url;
    public $version;
    public $description;
    protected $pluginName;
    protected $pluginPath;
    protected $options = [];
    protected $routes  = [];

    public function __construct($pluginName, $values = [])
    {
        $this->pluginName = $pluginName;
        $this->pluginPath = PLUGINS_PATH . $pluginName . DS;

        foreach ($values as $key => $value) {
            $this->options[$key] = $value;
        }
    }

    public function setInfosFromIniFile()
    {
        $infos             = parse_ini_file($this->pluginPath . 'info.ini');
        $this->name        = $infos['name'];
        $this->author      = $infos['author'];
        $this->author_mail = $infos['author_mail'];
        $this->author_url  = $infos['author_url'];
        $this->version     = $infos['version'];
        $this->description = $infos['description'];
    }

    public function isValid()
    {
        return (is_file($this->pluginPath . 'info.ini') && is_file($this->pluginPath . $this->pluginName . '.php'));
    }

    public function load()
    {
        $this->loadRoutes();
        require_once $this->pluginPath . $this->pluginName . '.php';
    }

    protected function loadRoutes()
    {
        if (file_exists($this->pluginPath . 'routes.php')) {
            $this->routes = require $this->pluginPath . 'routes.php';
        }
    }

    public function getName()
    {
        return $this->pluginName;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getLanguagePath()
    {
        return $this->pluginPath . 'lang' . DS;
    }

    public function isInstalled()
    {
        return !empty($this->options);
    }

    public function isActive()
    {
        if (!isset($this->options['active'])) {
            return false;
        }
        return $this->options['active'];
    }

    public function getInstallUrl()
    {
        return ROOT_URL . 'admin/plugins/install/' . $this->pluginName;
    }

    public function getUninstallUrl()
    {
        return ROOT_URL . 'admin/plugins/uninstall/' . $this->pluginName;
    }

    public function getActiveUrl()
    {
        return ROOT_URL . 'admin/plugins/active/' . $this->pluginName;
    }

    public function getUnactiveUrl()
    {
        return ROOT_URL . 'admin/plugins/unactive/' . $this->pluginName;
    }

    public function jsonSerialize()
    {
        return $this->options;
    }

    public function disable()
    {
        $this->options['active'] = false;
    }

    public function enable()
    {
        $this->options['active'] = true;
    }

}
