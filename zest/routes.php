<?php

/**
 * routes
 *
 * Routes are core system to dispatch user from requested URI
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */
return [
    // Homepage : list all articles
    '/'                                       => ['Zest\Controllers\Articles', 'allArticles', 998],
    // List articles with pagination
    '/page<#page>'                            => ['Zest\Controllers\Articles', 'allArticles'],
    // Login/Logout
    '/login'                                  => ['Zest\Controllers\Login', 'login'],
    '/logout'                                 => ['Zest\Controllers\Login', 'logout'],
    // Admin Homepage
    '/admin'                                  => ['Zest\Controllers\Admin\Homepage', 'allArticles'],
    // Articles List
    '/admin/articles'                         => ['Zest\Controllers\Admin\Homepage', 'allArticles'],
    // Edit articles
    '/admin/write'                            => ['Zest\Controllers\Admin\Write', 'new_article'],
    '/admin/write/getencodedtitle'            => ['Zest\Controllers\Admin\Write', 'getEncodedTitle'],
    '/admin/write/getpreview'                 => ['Zest\Controllers\Admin\Write', 'getPreview'],
    '/admin/write/edit/<#id>'                 => ['Zest\Controllers\Admin\Write', 'edit_article'],
    '/admin/delete/<#id>'                     => ['Zest\Controllers\Admin\Write', 'deleteArticle'],
    // Read a specified article by its encoded title
    '/articles/<:article_name>'               => ['Zest\Controllers\Articles', 'viewArticle', 999],
    // Plugins
    '/admin/plugins'                          => ['Zest\Controllers\Admin\Plugins', 'viewAllPlugins'],
    '/admin/plugins/unactive/<:plugin_name>'  => ['Zest\Controllers\Admin\Plugins', 'disablePlugin'],
    '/admin/plugins/active/<:plugin_name>'    => ['Zest\Controllers\Admin\Plugins', 'enablePlugin'],
    '/admin/plugins/install/<:plugin_name>'   => ['Zest\Controllers\Admin\Plugins', 'installPlugin'],
    '/admin/plugins/uninstall/<:plugin_name>' => ['Zest\Controllers\Admin\Plugins', 'uninstallPlugin'],
    // Config
    '/admin/config'                           => ['Zest\Controllers\Admin\Config', 'config'],
];
