<?php

/**
 * Articles
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Controllers;

use Zest\Templates\Template as Template,
    Zest\Responses\Site as SiteResponse;

/**
 * Controller to display articles
 */
class Articles extends \Zest\Core\Controller
{

    public function viewArticle($article_url)
    {
        $art = \Zest\Managers\Articles::getArticleByEncodedTitle($article_url);
        if (!$art) {
            $this->getZest()->call404Error();
        }
        $tpl      = new Template('view_article.tpl');
        $tpl->set('article', $art);
        $response = new SiteResponse();
        $response->addTemplate($tpl);
        $response->setTitle($art->title);
        return $response;
    }

    public function allArticles($page = 1)
    {
        $page       = (int) $page;
        $pagination = new \Zest\Utils\Pagination($this->config->get('site', 'articles_per_page'), \Zest\Managers\Articles::countAllArticles());
        if ($page > $pagination->getNumberPages()) {
            $page = $pagination->getNumberPages();
        }
        $pagination->setActualPage($page);
        $pagination->setUrl(ROOT_URL . 'page$1');
        $first_item = ($page - 1) * $this->config->get('site', 'articles_per_page');
        $articles   = \Zest\Managers\Articles::getManyArticlesSortedByCreation($first_item, $this->config->get('site', 'articles_per_page'));

        $response = new SiteResponse();
        $response->setTitle($this->config->get('site', 'title'));

        $tpl = new Template('articles_list.tpl');

        $tpl->set('articles', $articles);
        $response->addTemplate($tpl);

        if ($pagination->needPagination()) {
            $response->addTemplate(new \Zest\Templates\StringTemplate($pagination->output()));
        }
        return $response;
    }

}
