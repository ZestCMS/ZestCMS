<?php

/**
 * Articles
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Managers;

/**
 * Manager to get, create and edit articles
 */
class Articles
{
    /**
     * Constants to search By
     */
    const   SEARCH_ID = 'id',
            SEARCH_ENCODED_TITLE = 'encoded_title';
    /**
     * Get an article by his encoded title
     * 
     * @param string Article encoded title
     * @return \self
     */
    public static function getArticleByEncodedTitle($title)
    {
        $article = self::loadArticle($title, self::SEARCH_ENCODED_TITLE);
        return $article;
    }
    
    /**
     * Get many articles, ordered by creation (timestamp)
     * 
     * @param int       First item to get
     * @param int       Number of articles to get 
     * @return array    Array with Articles
     */
    public static function getManyArticlesSortedByCreation($first_item, $number)
    {
        $metas = self::getArticlesMetas();
        
        // Sort by timestamp DESC
        usort($metas, 'self::compareCreationDesc');
        $array = array_slice($metas, $first_item, $number, true);
        $articles = [];
        
        foreach ($array as $art)
        {
            $articles[] = self::loadArticle($art['id'], self::SEARCH_ID);
        }
        return $articles;
    }
    
    public static function getAllArticles()
    {
        $metas = self::getArticlesMetas();
        // Sort by timestamp DESC
        usort($metas, 'self::compareCreationDesc');
        $articles = [];
        
        foreach ($metas as $art)
        {
            $articles[] = self::loadArticle($art['id'], self::SEARCH_ID);
        }
        return $articles;
    }
    
    /**
     * Get an article with an info
     * 
     * @param mixed     Info to search
     * @param int       Info type
     * @return \Zest\Entities\Article
     */    
    public static function loadArticle($info, $search_info = self::SEARCH_ID)
    {
        $articles = self::getArticlesMetas();
        $id = array_search($info, array_column($articles, $search_info, 'id'));
        if (!isset($articles[$id]))
        {
            // Article doesnt exist
            return false;
        }
        $art = $articles[$id];
        $article = new \Zest\Entities\Article();
        
        $file = ARTICLES_PATH . $art['encoded_title'] . '.md';
        if (!file_exists($file))
        {
            return false;
        }
        $art['content'] = file_get_contents($file);

        $article->hydrateByArray($art);
        return $article;
    }
    
    /**
     * Save an article
     * @param \Zest\Entities\Article Article
     */
    public static function saveArticle(\Zest\Entities\Article $article)
    {
        if (!$article->isValid())
        {
            // Article need to be valid to be saved
            return false;
        }
        // Search and delete old MD file
        $old = self::loadArticle($article->id, self::SEARCH_ID);
        $oldfile = ARTICLES_PATH . $old->encoded_title . '.md';
        @unlink($oldfile);
        
        // Save new article
        $filename = ARTICLES_PATH . $article->encoded_title . '.md';
        file_put_contents($filename, $article->content);
        
        $jsonfile = ARTICLES_PATH . 'articles.json';
        
        $metas = self::getArticlesMetas();
        $metas[$article->id] = $article;
        $art = json_encode($metas, JSON_NUMERIC_CHECK + JSON_PRETTY_PRINT);
        file_put_contents($jsonfile, $art);
    }
    
    /**
     * 
     * @param type $id
     * @return boolean
     */
    public static function deleteArticle($id)
    {
        $article = self::loadArticle($id, self::SEARCH_ID);
        if (!$article)
        {
            return false;
        }
        $metas = self::getArticlesMetas();
        
        //Delete MD file
        unlink(ARTICLES_PATH . $article->encoded_title . '.md');
        
        unset($metas[$article->id]);
        
        $jsonfile = ARTICLES_PATH . 'articles.json';
        
        $art = json_encode($metas, JSON_NUMERIC_CHECK);
        file_put_contents($jsonfile, $art);
    }
    
    /**
     * Get all metas articles
     * 
     * @return array    Metas articles
     */
    private static function getArticlesMetas()
    {
        return json_decode(file_get_contents(ARTICLES_PATH . 'articles.json'), true);
    }
    
    /**
     * Return the higher ID used by all articles
     * 
     * @return int Max ID
     */
    public static function getMaxID()
    {
        return max(array_keys(self::getArticlesMetas()));
    }
    
    /**
     * Returns the number of articles contained in the site
     * 
     * @return int  Number of articles
     */
    public static function countAllArticles()
    {
        return count(self::getArticlesMetas());
    }
    
    /**
     * Compare 2 arrays by creation (timestamp) DESC
     * 
     * @see self::getManyArticlesSortedByCreation
     * 
     * @param array First array
     * @param array 2nd array
     * @return int  Result
     */
    private static function compareCreationDesc($a, $b)
    {
        if ($a['creation'] == $b['creation']) 
        {
            return 0;
        }
        return ($a['creation'] > $b['creation']) ? -1 : 1;
    }
}
