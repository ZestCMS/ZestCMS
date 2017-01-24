<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminHomepageController
 *
 * @author Toss
 */
class AdminHomepageController extends AdminController
{
    public function allArticles()
    {
        $articles = ArticleEntity::getAllArticles();
        $response = new Response();
        
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
    
    public function deleteArticle($id)
    {
        $art = ArticleEntity::getArticleByID($id);
        if ($art)
        {
            $art->delete();
        }
        return $this->allArticles();
    }
}
