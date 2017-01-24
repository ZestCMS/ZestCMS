<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminController
 *
 * @author Toss
 */
abstract class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true)
        {
            $this->getZest()->call404Error();
        }
    }
}
