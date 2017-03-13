<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Zest\Core;

/**
 * Description of Hooks
 *
 * @author Toss
 */
class HookManager
{

    protected static $hooks_filters = [];
    protected static $hooks_actions = [];

    public static function register_action($name, $callback)
    {
        self::$hooks_actions[$name][] = $callback;
    }

    public static function execute_action($name, $params = null)
    {
        if (!isset(self::$hooks_actions[$name]) || !is_array(self::$hooks_actions[$name])) {
            return 0;
        }
        foreach (self::$hooks_actions[$name] as $callback) {
            if (is_array($callback)) {
                call_user_func([$callback[0], $callback[1]], $params);
            }
            else {
                call_user_func($callback, $params);
            }
        }
        return;
    }

    public static function register_filter($name, $callback)
    {
        self::$hooks_filters[$name][] = $callback;
    }

    public static function execute_filter($name, $content, $params = null)
    {
        if (!isset(self::$hooks_filters[$name]) || !is_array(self::$hooks_filters[$name])) {
            return false;
        }
        foreach (self::$hooks_filters[$name] as $callback) {
            if (is_array($callback)) {
                $content = call_user_func_array([$callback[0], $callback[1]], [$content, $params]);
            }
            else {
                $content = call_user_func_array($callback[0], [$content, $params]);
            }
        }
        return $content;
    }

}
