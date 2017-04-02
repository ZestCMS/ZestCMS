<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Zest\Utils;

/**
 * Description of Message
 *
 * @author Toss
 */
class Message
{

    public $name;
    public $class;
    public $content;
    public $closable;

    const SUCCESS = 'success';
    const ERROR   = 'error';
    const WARNING = 'warning';
    const NOTICE  = 'notice';

    public function __construct($name, $class, $content, $closable = true)
    {
        $this->name     = $name;
        $this->class    = $class;
        $this->content  = $content;
        $this->closable = $closable;
    }

    public function __toString()
    {
        $tpl = new \Zest\Templates\Template('msg.tpl');
        $tpl->set('MSG', $this);
        return $tpl->output();
    }

}
