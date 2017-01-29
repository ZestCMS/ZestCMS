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
    '/' => ['Zest\Controllers\Articles', 'allArticles'],
    
    // List articles with pagination
    '/page<#page>' => ['Zest\Controllers\Articles', 'allArticles'],
    
    // Login/Logout
    '/login' => ['Zest\Controllers\Login', 'login'],
    '/logout' => ['Zest\Controllers\Login', 'logout'],
    
    // Admin Homepage
    '/admin' => ['Zest\Controllers\AdminHomepage', 'allArticles'],
    
    '/admin/write' =>['Zest\Controllers\AdminWrite', 'new_article'],
    '/admin/write/getencodedtitle' =>['Zest\Controllers\AdminWrite', 'getEncodedTitle'],
    '/admin/write/getpreview' =>['Zest\Controllers\AdminWrite', 'getPreview'],
    '/admin/write/edit/<#id>' => ['Zest\Controllers\AdminWrite', 'edit_article'],
    '/admin/delete/<#id>' => ['Zest\Controllers\AdminWrite', 'deleteArticle'],
    
    // Read a specified article by its encoded title
    '/<:article_name>'=> ['Zest\Controllers\Articles', 'viewArticle', 999],

];