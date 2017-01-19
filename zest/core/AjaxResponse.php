<?php

/**
 * AjaxResponse
 * 
 * Provide a way to return datas to an Ajax request
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/MaxenceCauderlier/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */
class AjaxResponse extends Response
{
    /**
     * Display the response
     */
    public function output()
    {
        $content = '';
        foreach ($this->tpl as $tpl)
        {
            $content .= $tpl->output();
        }
        echo $content;
    }
}
