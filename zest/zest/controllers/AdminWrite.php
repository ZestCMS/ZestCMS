<?php

/**
 * AdminWrite
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Controllers;

use Zest\Templates\Template as Template,
    Zest\Templates\StringTemplate as StringTemplate,
    Zest\Responses\Admin as SiteResponse,
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
        $editor = new \Zest\Utils\Editor('article');
        
        
        if (isset($_POST['save_article']))
        {
            $_POST['content'] = $editor->getPOSTContent();
            $art = new \Zest\Entities\Article();
            $art->hydrateByArray($_POST);
            if ($art->isValid())
            {
                if(!\Zest\Managers\Articles::getArticleByEncodedTitle($art->encoded_title) || $_POST['id'] !== '')
                {
                    // Encoded title is not already used or Article isnt a new
                    $art->save();
                    header('Location:' . $art->url);
                    exit();
                }
                $tpl->set('error', 'URL Article is already used');
            }
            $tpl->set('article', $art);
            
        }
        $tpl->set('EDITOR', $editor);
        $response->addTemplate($tpl);
        $response->setTitle('Article Write');
        return $response;
    }
    
    public function edit_article($id)
    {
        $response = new SiteResponse();
        $editor = new \Zest\Utils\Editor('article');
        $art = \Zest\Managers\Articles::loadArticle($id, \Zest\Managers\Articles::SEARCH_ID);
        if ($art === false)
        {
            $this->getZest()->call404Error();
        }
        $editor->setContent($art->content);
        $tpl = new Template('admin/write.tpl');
        $tpl->set('EDITOR', $editor);
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
        if (isset($_POST['editor_preview']))
        {
            $content = $_POST['editor_preview'];
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
