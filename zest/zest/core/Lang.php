<?php

/**
 * Lang
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Core;

/**
 * Lang provide a way to translate easily Zest in differents languages
 */
class Lang
{
    /**
     * Translation
     * @var string 
     */
    protected $_translation;
    
    /**
     * Language sentences
     * @var array
     */
    protected $_data;
    
    /**
     * Set translation
     * @param string    Translation
     */
    public function __construct($translation)
    {
        $file = LANGS_PATH . $translation . '.php';
        if (file_exists($file))
        {
            $this->_translation = $translation;
        }
        else
        {
            throw new Exception('Language file ' . $translation . ' seem not exist');
        }
        $this->_data = require $file;
    }
    
    public function __get($name)
    {
        return isset($this->_data[$name]) ? $this->_data[$name] : false;
    }
    
    public function getAllLanguagesDatas()
    {
        return $this->_data;
    }
}
