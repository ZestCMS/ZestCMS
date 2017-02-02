<?php

/**
 * Pagination
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Utils;

/**
 * Tool for paginate articles
 */
class Pagination
{
    private $actual_page;
    
    private $items_per_page;
    
    private $page_max;

    private $url;
    
    public function __construct($items_per_page, $items)
    {
        $this->items_per_page = $items_per_page;
        $this->page_max = (int)ceil($items / $items_per_page);
    }
    
    public function setActualPage($actual_page)
    {
        $this->actual_page = $actual_page;
    }
    
    public function getNumberPages()
    {
        return $this->page_max;
    }
    
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    public function needPagination()
    {
        if ($this->page_max > 1)
        {
            return true;
        }
        return false;
    }
    
    public function output()
    {
        $str = '<div class="pagination"><ul>';
        if ($this->actual_page !== 1)
        {
            $str .= '<li><a href="' . str_replace('$1', 1, $this->url) . '"' . '>{{LANG.pagination_newers}}</a>';
        }
        for($i = 1;$i <= $this->page_max; $i++)
        {
            $str .= '<li>';
            
            if ($this->actual_page === $i)
            {
                $str .= $i;
            }
            else
            {
                $str .= '<a href="';
                $str .= str_replace('$1', $i, $this->url) . '"';
                $str .= '>' . $i . '</a>';
            }
            
        }
        if ($this->actual_page !== $this->page_max)
        {
            $str .= '<li><a href="' . str_replace('$1', $this->page_max, $this->url) . '"' . '>{{LANG.pagination_olders}}</a>';
        }
        $str .= '</ul></div>';
        return $str;
    }
    
    
}
