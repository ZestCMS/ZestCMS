<?php

/**
 * Helper
 * 
 * Simple class with only statics method to provide helpers
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/MaxenceCauderlier/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */
class Helper
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

}
