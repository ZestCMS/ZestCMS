<?php

/**
 * routes
 * 
 * Routes are core system to dispatch user from requested URI
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/MaxenceCauderlier/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

return [
    // Homepage : list all articles
    '/' => ['ArticlesController', 'allArticles'],
    // List articles with pagination
    '/page<#page>' => ['ArticlesController', 'allArticles'],
    // Read a specified article by its encoded title
    '/articles/<:article_name>'=> ['ArticlesController', 'viewArticle'],
    
    '/login' => ['LoginController', 'login'],
    '/logout' => ['LoginController', 'logout'],
    '/admin' => ['AdminHomepageController', 'allArticles'],
    '/admin/write' =>['AdminWriteController', 'new_article'],
    '/admin/write/getencodedtitle' =>['AdminWriteController', 'getEncodedTitle'],
    '/admin/write/getpreview' =>['AdminWriteController', 'getPreview'],
    '/admin/write/edit/<#id>' => ['AdminWriteController', 'edit_article'],
    '/admin/delete/<#id>' => ['AdminHomepageController', 'deleteArticle'],

];