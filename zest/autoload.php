<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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