<?php

/**
 * AdminHomepage
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/MaxenceCauderlier/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Controllers;

use Zest\Templates\Template as Template,
    Zest\Responses\Site as SiteResponse;

/**
 * Administration Homepage
 */
class AdminHomepage extends \Zest\Core\AdminController
{
    public function allArticles()
    {
        $articles = \Zest\Managers\Articles::getAllArticles();
        $response = new SiteResponse();
        
        $tpl = new Template('admin/articles_list.tpl');
        foreach ($articles as &$art)
        {
            $art->edit_url = $this->getZest()->getRootUrl() . 'admin/write/edit/' . $art->id;
            $art->delete_url = $this->getZest()->getRootUrl() . 'admin/delete/' . $art->id;
        }
        $tpl->set('articles', $articles);
        
        $response->setTitle($this->site_config['title'] . ' : Administration');
        $response->addTemplate($tpl);
        return $response;
    }
    
}
