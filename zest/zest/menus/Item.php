<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Zest\Menus;

/**
 * Description of Item
 *
 * @author Toss
 */
class Item
{

    protected $title;
    protected $link;
    protected $id;
    protected $items;

    public function __construct($title, $options)
    {
        $this->title = $title;
        $this->id    = isset($options['id']) ? $options['id'] : uniqid();
        $url         = isset($options['url']) ? $options['url'] : '';
        $this->link  = new Link($this->title, $url, $this->id);
    }

    public function addItem($title, $options, $priority = 50)
    {
        $item                     = new self($title, $options, $priority);
        $this->items[$priority][] = $item;
        return $item;
    }

    public function output()
    {

        $str = '<li>' . $this->link->output();
        if ($this->hasItems()) {
            ksort($this->items);
            $str .= '<ul>';
            foreach ($this->items as $priority => $items) {
                foreach ($items as $item) {
                    $str.= $item->output();
                }
            }
            $str .= '</ul>';
        }
        $str .= '</li>';
        return $str;
    }

    public function hasItems()
    {
        return !empty($this->items);
    }

    public function getItem($id)
    {
        // Search Himself
        if ($this->id === $id) {
            return $this;
        }

        // Search in Sub
        if (!$this->hasItems()) {
            return false;
        }
        foreach ($this->items as $priority => $items) {
            foreach ($items as $item) {
                if ($item->getItem($id) !== false) {
                    return $item->getItem($id);
                }
            }
        }

        return false;
    }

}
