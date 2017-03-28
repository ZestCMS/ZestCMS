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
    Zest\Responses\Site as SiteResponse,
    \Zest\Utils\Authentication as Authentication;

/**
 * Controller to login/logout
 */
class Login extends \Zest\Core\Controller
{

    public function login()
    {
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
            // Already logged
            header('Location: ' . ROOT_URL . 'admin');
            exit();
        }
        if (isset($_POST['login'])) {
            if (Authentication::isPasswordAdmin($_POST['password'])) {
                $_SESSION['is_admin'] = true;
                header('Location: ' . ROOT_URL . 'admin');
                exit();
            }
        }
        $tpl      = new Template('login.tpl');
        $response = new SiteResponse();
        $response->setTitle($this->getZest()->getSiteTitle() . ' : Login');
        $response->addTemplate($tpl);
        return $response;
    }

    public function logout()
    {
        unset($_SESSION['is_admin']);
        header('Location: ' . ROOT_URL);
        exit();
    }

}
