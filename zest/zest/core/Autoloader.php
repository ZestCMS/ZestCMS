<?php

/**
 * Autoloader
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Core;

/**
 * Autoloader to load modules and system classes
 */
class Autoloader
{

    static public function load($className)
    {
        $arr  = explode('\\', $className);
        if ($arr[0] === 'Zest')
        {
            $path = self::loadZestClass($className);
        }
        elseif ($arr[0] === 'Plugins')
        {
            // To autoload plugins or more
            $path = self::loadPluginsClass($className);
        }
        else
        {
            $path = "";
        }
        
        if (file_exists($path))
        {
            include($path);
            if (class_exists($className))
            {
                return TRUE;
            }
        }
        return FALSE;
    }
    
    private static function loadZestClass($className)
    {
        $arr  = explode('\\', $className);
        array_splice($arr, 1, 0, rtrim(CORE_PATH, DS));
        $path = '';
        foreach ($arr as $key => $val)
        {
            if ($key != count($arr) - 1)
            {
                $path .= strtolower($val) . DS;
            }
            else
            {
                $path .= $val . '.php';
            }
        }
        return $path;
    }
    
    private static function loadPluginsClass($className)
    {
        $arr  = explode('\\', $className);
        array_shift($arr);
        
        $path = PLUGINS_PATH;
        foreach ($arr as $key => $val)
        {
            if ($key != count($arr) - 1)
            {
                $path .= strtolower($val) . DS;
            }
            else
            {
                $path .= $val . '.php';
            }
        }
        return $path;
    }

}

spl_autoload_register('Zest\Core\Autoloader::load');
