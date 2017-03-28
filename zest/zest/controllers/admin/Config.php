<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Zest\Controllers\Admin;

use Zest\Responses\Admin as AdminResponse,
    Zest\Templates\Template as Template,
    \Zest\Utils\Authentication as Authentication;

/**
 * Description of Config
 *
 * @author Toss
 */
class Config extends \Zest\Core\AdminController
{

    public function config()
    {
        $response = new AdminResponse();
        $response->setTitle('Configuration');
        $tpl      = new Template('admin/config.tpl');

        if (isset($_POST['save_config'])) {
            // Save configuration
            $this->postProcess();
        }

        $tpl->set('sitename', $this->config->get('site', 'title'));
        $tpl->set('articles_per_page', $this->config->get('site', 'articles_per_page'));
        $tpl->set('date_format', $this->config->get('site', 'date_format'));

        $response->addTemplate($tpl);
        return $response;
    }

    private function postProcess()
    {
        $errors = false;
        $this->config->set('site', 'title', $_POST['sitename']);
        $this->config->set('site', 'articles_per_page', $_POST['articles_per_page']);
        $this->config->set('site', 'date_format', $_POST['date_format']);
        if (!empty($_POST['original_password']) || !empty($_POST['new_password']) || !empty($_POST['repeat_password'])) {
            // Try to change admin password
            if (Authentication::isPasswordAdmin($_POST['original_password'])) {
                // Password is good
                if ($_POST['new_password'] === $_POST['repeat_password']) {
                    $this->config->set('zest', 'password', Authentication::encodePassword($_POST['new_password']));
                }
                else {
                    $errors = true;
                }
            }
            else {
                $errors = true;
            }
        }
        $this->config->save();
    }

}
