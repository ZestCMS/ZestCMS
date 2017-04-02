<?php

/**
 * Config
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Controllers\Admin;

use Zest\Responses\Admin as AdminResponse,
    Zest\Templates\Template as Template,
    \Zest\Utils\Authentication as Authentication;

/**
 * Config Controller is place to display and modify site's configuration
 */
class Config extends \Zest\Core\AdminController
{

    /** @var \Zest\Templates\Template $tpl */
    private $tpl;

    public function config()
    {
        $response  = new AdminResponse();
        $response->setTitle('Configuration');
        $this->tpl = new Template('admin/config.tpl');

        if (isset($_POST['save_config'])) {
            // Save configuration
            $this->postProcess();
        }

        $this->tpl->set('sitename', $this->config->get('site', 'title'));
        $this->tpl->set('articles_per_page', $this->config->get('site', 'articles_per_page'));
        $this->tpl->set('date_format', $this->config->get('site', 'date_format'));

        $response->addTemplate($this->tpl);
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
                    $this->tpl->addMessage('passwordsdiff', \Zest\Utils\Message::ERROR, 'The both passwords are differents');
                }
            }
            else {
                $errors = true;
                $this->tpl->addMessage('wrong_pass', \Zest\Utils\Message::ERROR, 'Password is Wrong');
            }
        }
        else {

        }
        if (!$errors) {
            $this->config->save();
            $this->tpl->addMessage('config_saved', \Zest\Utils\Message::SUCCESS, 'Config was saved', true);
        }
    }

}
