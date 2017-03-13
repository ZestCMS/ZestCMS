<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Zest\Menus;

/**
 * Description of Menu
 *
 * @author Toss
 */
class Menu
{

    protected $id;
    protected $class;
    protected $items = [];

    public function __construct($id = '', $class = '')
    {
        $this->id    = $id;
        $this->class = $class;
    }

    public function addItem($title, $options, $priority = 50)
    {
        if (!isset($options['id'])) {
            $options['id'] = uniqid();
        }
        $item                     = new Item($title, $options, $priority);
        $this->items[$priority][] = $item;
        return $item;
    }

    public function output()
    {
        ksort($this->items);
        $str = '<ul id="' . $this->id . '" class="' . $this->class . '">';

        foreach ($this->items as $priority => $items) {
            foreach ($items as $item) {
                $str.= $item->output();
            }
        }
        $str .= '</ul>';
        return $str;
    }

    public function getItem($id)
    {
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
