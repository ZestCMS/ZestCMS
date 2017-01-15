<?php

/**
 * autoload
 * 
 * Autoload all class files in different system folders
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/MaxenceCauderlier/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */
function __autoload($classname)
{
    
    $paths = [
        CORE_PATH . 'core',
        CORE_PATH . 'controllers',
        CORE_PATH . 'entities'
    ];
    
    foreach ($paths as $path)
    {
        $filename = $path . DS . $classname . '.php';
        if(is_file($filename))
        {
            include($filename);
            return;
        }
    }

    throw new RuntimeException($classname . ' was not found');    
}