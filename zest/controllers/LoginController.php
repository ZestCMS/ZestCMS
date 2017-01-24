<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginController
 *
 * @author Toss
 */
class LoginController extends Controller
{
    public function login()
    {
        if (isset($_POST['login']))
        {
            if ($this->isPasswordAdmin($_POST['password']))
            {
                $_SESSION['is_admin'] = true;
                header('Location: ' . $this->getZest()->getRootUrl() . 'admin');
                exit();
            }
        }
        $tpl = new Template('login.tpl');
        $response = new Response();
        $response->setTitle($this->site_config['title'] . ' : Page not found');
        $response->addTemplate($tpl);
        return $response;
    }
    
    public function logout()
    {
        unset($_SESSION['is_admin']);
        header('Location: ' . $this->getZest()->getRootUrl());
        exit();
    }
    
    private function getAdminPassword()
    {
        return sha1($this->zest_config['password_salt'] . $this->zest_config['password']);
    }
    
    private function encodePassword($pass)
    {
        return sha1($this->zest_config['password_salt'] . sha1($pass));
    }
    
    private function isPasswordAdmin($pass)
    {
        return ($this->encodePassword($pass) === $this->getAdminPassword());
    }
}
