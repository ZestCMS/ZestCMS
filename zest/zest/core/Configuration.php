<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Zest\Core;

class Configuration
{

    protected $values = [];

    public function __construct()
    {
        $values = parse_ini_file(CORE_PATH . 'config.ini', true);

        foreach ($values as $sectionName => $section) {
            foreach ($section as $key => $value) {
                $this->values[$sectionName][$key] = $value;
            }
        }
    }

    public function set($section, $name, $value)
    {
        $this->values[$section][$name] = $value;
    }

    public function get($section, $name)
    {
        return isset($this->values[$section][$name]) ? $this->values[$section][$name] : null;
    }

    public function save()
    {
        $file = '';
        foreach ($this->values as $sectionName => $section) {
            $file .= '[' . $sectionName . ']' . "\n";
            foreach ($section as $key => $value) {
                $file .= $key . ' = ' . $value . "\n";
            }
        }
        file_put_contents(CORE_PATH . 'config.ini', $file);
    }

}
