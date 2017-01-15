<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define('DS', DIRECTORY_SEPARATOR);

define('CORE_PATH', 'zest' . DS);

define('CONTENT_PATH', 'content' . DS);

define('THEMES_PATH', 'themes' . DS);

require CORE_PATH . 'autoload.php';

$Zest = Zest::getInstance();
$Zest->run();