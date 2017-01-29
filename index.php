<?php

/**
 * Index
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/MaxenceCauderlier/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

/*
 * Zest directory
 */
define('CORE_PATH', 'zest' . DIRECTORY_SEPARATOR);

/**
 * Themes directory
 */
define('THEMES_PATH', 'themes' . DIRECTORY_SEPARATOR);


/* ------------------------------------
 * 
 * Do not modify under this
 * 
 * ----------------------------------*/

define('DS', DIRECTORY_SEPARATOR);

/**
 * Langs directory
 */
define('LANGS_PATH', CORE_PATH . 'langs' . DS);

/**
 * Content directory
 */
define('CONTENT_PATH', CORE_PATH . 'content' . DS);

/**
 * Articles directory
 */
define('ARTICLES_PATH', CONTENT_PATH . 'articles' . DS);

require CORE_PATH . 'zest' . DS . 'core' . DS . 'Autoloader.php';

$zest = Zest\Core\Zest::getInstance();

$zest->run();
