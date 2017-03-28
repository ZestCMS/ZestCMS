<?php

/**
 * AdminHomepage
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Controllers;

use Zest\Templates\Template as Template,
    Zest\Responses\Admin as Response;

/**
 * Administration Homepage
 */
class AdminHomepage extends \Zest\Core\AdminController
{

    public function allArticles()
    {
        $articles = \Zest\Managers\Articles::getAllArticles();
        $response = new Response();

        $tpl = new Template('admin/articles_list.tpl');
        foreach ($articles as &$art) {
            $art->edit_url   = ROOT_URL . 'admin/write/edit/' . $art->id;
            $art->delete_url = ROOT_URL . 'admin/delete/' . $art->id;
        }
        $tpl->set('articles', $articles);

        $response->setTitle($this->config->get('site', 'title') . ' : Administration');
        $response->addTemplate($tpl);
        return $response;
    }

}
