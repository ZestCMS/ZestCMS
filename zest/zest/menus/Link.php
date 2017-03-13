<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Zest\Menus;

/**
 * Description of Link
 *
 * @author Toss
 */
class Link
{

    protected $title;
    protected $url;
    protected $id;

    public function __construct($title, $url, $id)
    {
        $this->title = $title;
        $this->url   = $url;
        $this->id    = $id;
    }

    public function output()
    {
        return '<a href="' . $this->url . '" id="' . $this->id . '">' . $this->title . '</a>';
    }

}
