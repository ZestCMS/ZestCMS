<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminWriteController
 *
 * @author Toss
 */
class AdminWriteController extends AdminController
{
    public function new_article()
    {
        $response = new Response();
        $tpl = new Template('admin/write.tpl');
        if (isset($_POST['save_article']))
        {
            $_POST['content'] = $_POST['artcontent'];
            $art = new ArticleEntity();
            $art->hydrateByArray($_POST);
            if ($art->isValid())
            {
                if(!ArticleEntity::getArticleByName($art->encoded_title) || $_POST['id'] !== '')
                {
                    // Encoded title is not already used
                    $art->save();
                    header('Location:' . $this->getZest()->getRootUrl() . 'articles/' . $art->encoded_title);
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
        $response = new Response();
        $art = ArticleEntity::getArticleByID($id);
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
        $encoded_title = Helper::normalizeString($title);
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
        $parser = new ParsedownExtra();
        
        $res->addTemplate(new StringTemplate($parser->text($content)));
        return $res;
    }
}
