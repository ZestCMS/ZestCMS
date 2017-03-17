<?php

/**
 * Plugins
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Controllers\Admin;

use Zest\Templates\Template as Template,
    Zest\Responses\Admin as Response;

/**
 * Plugins management
 */
class Plugins extends \Zest\Core\AdminController
{

    public function installedPlugins()
    {
        $plugins  = \Zest\Core\PluginsManager::searchPlugins();
        $response = new Response();

        $tpl = new Template('admin/plugins.tpl');

        $tpl->set('plugins', $plugins);

        $response->setTitle($this->site_config['title'] . ' : Administration');
        $response->addTemplate($tpl);
        return $response;
    }

    public function disablePlugin($pluginName)
    {
        $disable = \Zest\Core\PluginsManager::disablePlugin($pluginName);
        $this->getZest()->redirect(\Zest\Utils\URLBuilder::getURLAdminPluginsManagement());
    }

    public function enablePlugin($pluginName)
    {
        $enable = \Zest\Core\PluginsManager::enablePlugin($pluginName);
        $this->getZest()->redirect(\Zest\Utils\URLBuilder::getURLAdminPluginsManagement());
    }

}
