<?php

/**
 * AdminWrite
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/MaxenceCauderlier/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Controllers;

use Zest\Templates\Template as Template,
    Zest\Templates\StringTemplate as StringTemplate,
    Zest\Responses\Site as SiteResponse,
    Zest\Responses\Ajax as AjaxResponse;

/**
 * Write, edit and delete articles
 */
class AdminWrite extends \Zest\Core\AdminController
{
    public function new_article()
    {
        $response = new SiteResponse();
        $tpl = new Template('admin/write.tpl');
        if (isset($_POST['save_article']))
        {
            $_POST['content'] = $_POST['artcontent'];
            $art = new \Zest\Entities\Article();
            $art->hydrateByArray($_POST);
            if ($art->isValid())
            {
                if(!\Zest\Managers\Articles::getArticleByEncodedTitle($art->encoded_title) || $_POST['id'] !== '')
                {
                    // Encoded title is not already used or Article isnt a new
                    $art->save();
                    header('Location:' . $this->getZest()->getRootUrl() . $art->encoded_title);
                    exit();
                }
                $tpl->set('error', 'URL Article is already used');
            }
            $tpl->set('article', $art);
        }
        $response->addTemplate($tpl);
        $response->setTitle('Article Write');
        return $response;
    }
    
    public function edit_article($id)
    {
        $response = new SiteResponse();
        $art = \Zest\Managers\Articles::loadArticle($id, \Zest\Managers\Articles::SEARCH_ID);
        if ($art === false)
        {
            $this->getZest()->call404Error();
        }
        $tpl = new Template('admin/write.tpl');
        $tpl->set('article', $art);
        $response->addTemplate($tpl);
        $response->setTitle('Article Write');
        return $response;
        
    }
    public function getEncodedTitle()
    {
        if (isset($_POST['title']))
        {
            $title = $_POST['title'];
        }
        else
        {
            exit();
        }
        $encoded_title = \Zest\Utils\ArticleHelper::normalizeString($title);
        $res = new AjaxResponse();
        $res->addTemplate(new StringTemplate($encoded_title));
        return $res;
    }
    
    public function getPreview()
    {
        if (isset($_POST['artcontent']))
        {
            $content = $_POST['artcontent'];
        }
        else
        {
            exit();
        }
        $res = new AjaxResponse();
        
        $res->addTemplate(new StringTemplate($this->getZest()->getParser()->parse($content)));
        return $res;
    }
    
    public function deleteArticle($id)
    {
        \Zest\Managers\Articles::deleteArticle($id);
        $Controller = new AdminHomepage();
        
        return $Controller->allArticles();
    }
}
