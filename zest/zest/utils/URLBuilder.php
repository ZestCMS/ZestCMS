<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Zest\Utils;

/**
 * Description of URLBuilder
 *
 * @author Toss
 */
class URLBuilder
{

    public static function getURLAdminHomePage()
    {
        return ROOT_URL . 'admin/';
    }

    public static function getURLAdminPluginsManagement()
    {
        return ROOT_URL . 'admin/plugins/';
    }

    public static function getURLAdminArticlesList()
    {
        return ROOT_URL . 'admin/articles/';
    }

    public static function getURLAdminArticleWrite()
    {
        return ROOT_URL . 'admin/write/';
    }

}
