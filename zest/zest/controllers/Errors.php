<?php

/**
 * Errors
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/MaxenceCauderlier/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Controllers;

use Zest\Templates\Template as Template,
    Zest\Responses\Site as SiteResponse;

/**
 * Controller to display errors
 */
class Errors extends \Zest\Core\Controller
{
    public function Page404()
    {
        $tpl = new Template('404.tpl');
        $response = new SiteResponse();
        $response->setTitle($this->site_config['title'] . ' : Page not found');
        $response->addTemplate($tpl);
        return $response;
    }
}
