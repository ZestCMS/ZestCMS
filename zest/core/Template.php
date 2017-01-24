<?php

/**
 * Template
 * 
 * Simple lightweight template parser.
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/MaxenceCauderlier/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */
class Template
{

    /** @var array  Constants */
    protected static $const = [];
    
    /** @var string Template path */
    protected $file;
    
    /** @var string Template content */
    protected $content;
    /** @var array  Assigned datas to replace */
    protected $data = [];

    /**
     * Constructor
     * Check if the template exist in the current theme, else template will be
     * taken from 'default' theme
     * 
     * @param string Template name with extension
     */
    public function __construct($file)
    {
        $site_config = Zest::getInstance()->getSiteConfig();
        $filename    = THEMES_PATH . $site_config['theme'] . DS . $file;
        if (is_file($filename))
        {
            $this->file = $filename;
        }
        else
        {
            $this->file = THEMES_PATH . 'default' . DS . $file;
        }
    }

    /**
     * Add a var who will be added to all templates
     * 
     * @static
     * @param string Var key
     * @param string Value
     */
    public static function addGlobal($key, $value)
    {
        self::$const[$key] = $value;
    }

    /**
     * Assign datas to this template
     * Datas can be string, numeric... or array and objects
     * 
     * @param string Var key
     * @param string Value
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Return the parsed template content
     * 
     * @return string Parsed content
     */
    public function output()
    {
        if (!file_exists($this->file))
        {
            return "Error loading template file ($this->file).<br/>";
        }
        ob_start();
        $this->get_content();
        $this->addGlobalsToVars();
        $this->parse();
        // Uncomment the next line to see parsed template
        //file_put_contents($this->file . '.cache.php', $this->content);
        eval('?>' . $this->content);
        return ob_get_clean();
    }

    /**
     * Get template content
     */
    private function get_content()
    {
        $this->content = file_get_contents($this->file);
    }

    /**
     * Parse template
     * Allowed tags :
     * {# This is multiline allowed comments #}
     * {% NOPARSE %} ... {% ENDNOPARSE %}
     * {% IF MY_VAR %} {% IF MY_VAR !== 25 %} ... {% ELSE %} ... {% ENDIF %}
     * {{ MY_VAR }}
     * {% FOR MY_VAR IN MY_VARS %} ... {{MY_VAR.name}} ... {% ENDFOR %}
     */
    protected function parse()
    {
        $this->content = preg_replace('#\{\#(.*)\#\}#isU', '<?php /* $1 */ ?>', $this->content);
        $this->content = preg_replace_callback('#\{\% *NOPARSE *\%\}(.*)\{\% *ENDNOPARSE *\%\}#isU', 'self::_no_parse', $this->content);
        $this->content = preg_replace_callback('#\{\% *IF +([0-9a-z_\.\-]+) *([\=|\<|\>|\!]{2,3}) *([0-9a-z_\.\-]+) *\%\}#i', 'self::_complexe_if_replace' , $this->content);
        $this->content = preg_replace_callback('#\{\% *IF +([0-9a-z_\.\-]+) *\%\}#i', 'self::_simple_if_replace', $this->content);
        $this->content = preg_replace('#\{\{ *([0-9a-z_\.\-]+) *\}\}#i', '<?php $this->_show_var(\'$1\'); ?>', $this->content);
        $this->content = preg_replace_callback('#\{\% *FOR +([0-9a-z_\.\-]+) +IN +([0-9a-z_\.\-]+) *\%\}#i', 'self::_replace_for', $this->content);
        $this->content = preg_replace('#\{\% *ENDFOR *\%\}#i', '<?php endforeach; ?>', $this->content);
        $this->content = preg_replace('#\{\% *ENDIF *\%\}#i', '<?php } ?>', $this->content);
        $this->content = preg_replace('#\{\% *ELSE *\%\}#i', '<?php }else{ ?>', $this->content);
        $this->content = str_replace('#/§&µ&§;#', '{', $this->content);
    }

    protected function _no_parse($matches)
    {
        return str_replace('{', '#/§&µ&§;#', $matches[1]);
    }
    
    protected function _show_var($name)
    {
        echo $this->getVar($name, $this->data);
    }

    protected function _complexe_if_replace($matches)
    {
        if (is_numeric($matches[1]))
        {
            $first = $matches[1];
        }
        else
        {
            $first = '$this->getVar(\'' . $matches[1] . '\', $this->data)';
        }
        if (is_numeric($matches[3]))
        {
            $thirst = $matches[3];
        }
        else
        {
            $thirst = '$this->data[' . $matches[3] . ']';
        }
        return '<?php if(' . $first . $matches[2] . $thirst . '){ ?>';
    }
    
    protected function _simple_if_replace($matches)
    {
        if (is_numeric($matches[1]))
        {
            $first = $matches[1];
        }
        else
        {
            $first = '$this->getVar(\'' . $matches[1] . '\', $this->data)';
        }
        return '<?php if(' . $first . '){ ?>';
    }

    protected function _replace_for($matches)
    {
        return '<?php foreach ($this->data[\'' . $matches[2] . '\'] as $' . $matches[1] . '): $this->data[\'' . $matches[1] . '\' ] = $' . $matches[1] . '; ?>';
    }
    
    /**
     * Recursive method to get asked var, with capacity to determine children
     * like : parent.child.var
     * 
     * @param string    Name of the asked var
     * @param mixed     Parent of the var
     * @return mixed    Asked var
     */
    protected function getVar($var, $parent)
    {
        $parts = explode('.', $var);
        if (count($parts) === 1)
        {
            // No child
            return $this->getSubVar($var, $parent);
        }
        else
        {
            // At least 1 child
            $name = array_shift($parts);
            $new_parent = $this->getSubVar($name, $parent);
            $var = join('.', $parts);
            // call recursive
            return $this->getVar($var, $new_parent);
        }
    }
    
    /**
     * Determine and return if asked var is var, attribut or method if parent 
     * is array or object
     * 
     * @param string    Name of the asked var
     * @param mixed     Parent of the var
     * @return mixed    Asked var
     */
    protected function getSubVar($var, $parent)
    {
        if (is_array($parent))
        {
            if (isset($parent[$var]))
            {
                return $parent[$var];
            }
            return '';
        }
        if (is_object($parent))
        {
            if (is_callable([$parent, $var]))
            {
                // Method
                return $parent->$var();
            }
            if (isset($parent->$var))
            {
                // Attribut
                return $parent->$var;
            }
            return '';
        }
        return '';
    }
    
    /**
     * Add Globals vars to datas template
     */
    protected function addGlobalsToVars()
    {
        foreach(self::$const as $key => $value)
        {
            $this->data[$key] = $value;
        }
    }
}
