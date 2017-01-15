<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Page404
 *
 * @author Toss
 */
class Page404Controller extends Controller
{
    public function error404()
    {
        $tpl = new Template('404.tpl');
        $response = new Response();
        $response->setTitle($this->site_config['title'] . ' : Page not found');
        $response->addTemplate($tpl);
        return $response;
    }
}
