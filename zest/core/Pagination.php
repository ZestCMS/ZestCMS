<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pagination
 *
 * @author Toss
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
        $this->page_max = ceil($items / $items_per_page);
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
        $str .= '</ul></div>';
        return $str;
    }
    
    
}
