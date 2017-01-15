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
];