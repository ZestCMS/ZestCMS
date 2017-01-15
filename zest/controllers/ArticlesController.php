<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArticlesController
 *
 * @author Toss
 */
class ArticlesController extends Controller
{
    public function viewArticle($article_name)
    {
        $article = ArticleEntity::getArticleByName($article_name);
        
        $tpl = new Template('article.tpl');
        $tpl->set('title', $article->title);
        $tpl->set('content', $article->content);
        $response = new Response();
        $response->setTitle($this->site_config['title']);
        $response->addTemplate($tpl);
        return $response;
    }
    
    public function allArticles($page = 1)
    {
        $page = (int) $page;
        $pagination = new Pagination($this->site_config['articles_per_page'],ArticleEntity::countAllArticles());
        if ($page > $pagination->getNumberPages())
        {
            $page = $pagination->getNumberPages();
        }
        $pagination->setActualPage($page);
        $pagination->setUrl($this->getZest()->getRootUrl() . 'page$1');
        $first_item = ($page-1) * $this->site_config['articles_per_page'];
        $articles = ArticleEntity::getArticlesByTimestamp($first_item, $this->site_config['articles_per_page']);
        $response = new Response();
        $response->setTitle($this->site_config['title']);
        
        foreach ($articles as $art)
        {
            $tpl = new Template('article.tpl');
            $tpl->set('title', $art->title);
            $tpl->set('content', ($art->content));
            $tpl->set('url', $this->getZest()->getRootUrl() .'articles/'. $art->encoded_title);
            $response->addTemplate($tpl);
        }
        if ($pagination->needPagination())
        {
            $response->addTemplate(new StringTemplate($pagination->output()));
        }
        return $response;
    }
}
