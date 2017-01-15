<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return [
    '/' => ['ArticlesController', 'allArticles'],
    '/page<#page>' => ['ArticlesController', 'allArticles'],
    '/articles/<:article_name>'=> array('ArticlesController', 'viewArticle'),
   // '/article/?<?#article_id>' => array('Home', 'article'),

];
