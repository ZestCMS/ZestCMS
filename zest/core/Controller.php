<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author Toss
 */
abstract class Controller
{
    protected $site_config;
    
    protected $zest_config;
    
    public function __construct()
    {
        $this->site_config = $this->getZest()->getSiteConfig();
        $this->zest_config = $this->getZest()->getZestConfig();
    }
    
    protected function getZest()
    {
        return Zest::getInstance();
    }
    
    
}
