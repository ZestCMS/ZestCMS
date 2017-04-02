<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Zest\Utils;

/**
 * Description of Authentication
 *
 * @author Toss
 */
class Authentication
{

    public static function getAdminPassword()
    {
        return \Zest\Core\Zest::getInstance()->config->get('zest', 'password');
    }

    public static function encodePassword($pass)
    {
        return sha1(\Zest\Core\Zest::getInstance()->config->get('zest', 'password_salt') . $pass);
    }

    public static function isPasswordAdmin($pass)
    {
        return (self::encodePassword($pass) === self::getAdminPassword());
    }

}
