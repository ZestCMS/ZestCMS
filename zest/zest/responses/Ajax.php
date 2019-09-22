<?php

/**
 * Ajax
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Responses;

/**
 * Provide a way to return datas to an Ajax request
 */
class Ajax extends Site
{
    /**
     * Display the response
     * 
     * @return string Content of all tpl added
     */
    public function output()
    {
        $content = '';
        foreach ($this->tpl as $tpl)
        {
            $content .= $tpl->output();
        }
        return $content;
    }
}
