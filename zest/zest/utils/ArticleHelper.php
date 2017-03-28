<?php

/**
 * ArticleHelper
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Utils;

/**
 * Some statics functions to provide helps for Articles
 */
class ArticleHelper
{

    /**
     * Normalize a string to be ready to use for a filename
     *
     * @param string    String to normalize
     * @return string   Normalized string
     */
    public static function normalizeString($string = '')
    {
        $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
        $string = preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', $string);
        $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
        $string = preg_replace(array('~[^0-9a-z]~i', '~[ -]+~'), ' ', $string);
        $string = str_replace(' ', '_', strtolower($string));

        return trim($string, ' _');
    }

    public static function date_format($timestamp)
    {
        $config = \Zest\Core\Zest::getInstance()->config;
        return date($config->get('site', 'date_format'), $timestamp);
    }

}
