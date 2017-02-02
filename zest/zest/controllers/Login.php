<?php

/**
 * Login
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Controllers;

use Zest\Templates\Template as Template,
    Zest\Responses\Site as SiteResponse;

/**
 * Controller to login/logout
 */
class Login extends \Zest\Core\Controller
{
    public function login()
    {
        if ($_SESSION['is_admin'] === true)
        {
            // Already logged
            header('Location: ' . $this->getZest()->getRootUrl() . 'admin');
            exit();
        }
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
        $response = new SiteResponse();
        $response->setTitle($this->site_config['title'] . ' : Login');
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
