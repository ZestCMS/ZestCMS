<?php

/**
 * ArticleEntity
 * 
 * Get and create articles from files or data
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/MaxenceCauderlier/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */
class ArticleEntity
{

    /**
     * Article ID
     * @var int ID 
     */
    public $id;
    
    /**
     * Article Content
     * @var string
     */
    public $content;
    
    /**
     * Article Title
     * @var string
     */
    public $title;
    
    /**
     * Article Timestamp creation
     * @var int
     */
    public $creationDate;
    
    /**
     * Article encoded title, used to access this article
     * @var string
     */
    public $encoded_title;
    
    /**
     * Article exist ?
     * true  : Article is already written in file
     * false : Article has no file
     * @var boolean
     */
    public $exist = false;
    
    /**
     * Articles files path
     * @var string
     */
    private static $postsPath;

    /**
     * Get an article by his encoded title
     * 
     * @param string Article encoded title
     * @return \self
     */
    public static function getArticleByName($name)
    {
        if (!isset(self::$postsPath))
        {
            self::initPaths();
        }

        $files = glob(self::$postsPath . DS . '*-*-' . $name . '.xml');
        $article = self::loadByFilename($files[0]);
        return $article;
    }
    
    /**
     * Get many articles, ordered by timestamp
     * 
     * @param int       First item to get
     * @param int       Number of articles to get 
     * @return array    Array with Articles
     */
    public static function getArticlesByTimestamp($first_item, $number)
    {
        if (!isset(self::$postsPath))
        {
            self::initPaths();
        }

        $art = [];
        $files = glob(self::$postsPath . DS . '*-*-*.xml');
        foreach ($files as $file)
        {
            $parts = explode('-', $file);
            $art[$parts[1]] = $file;
            
        }
        krsort($art, SORT_NUMERIC);
        $art = array_slice($art, $first_item, $number, true);
        $articles = [];
        
        foreach ($art as $key => $filename)
        {
            $articles[] = self::loadByFilename($filename);
        }
        return $articles;
    }

    /**
     * Returns the number of articles contained in the site
     * 
     * @return int  Number of articles
     */
    public static function countAllArticles()
    {
        if (!isset(self::$postsPath))
        {
            self::initPaths();
        }
        $files = glob(self::$postsPath . DS . '*-*-*.xml');
        return count($files);
    }
    
    /**
     * Init the Articles Path
     */
    private static function initPaths()
    {
        self::$postsPath = CONTENT_PATH;
    }
    
    /**
     * Get an article with his complete filename
     * 
     * @param string    Filename
     * @return \self    
     */
    private static function loadByFilename($filename)
    {
        $xml = new XMLFile($filename);
        $article = new self();
        $article->id = $xml->getUniqueTag('id');
        $article->creationDate = date('d/m/Y', $xml->getUniqueTag('creation'));
        $article->content = $xml->getUniqueTag('content');
        $article->encoded_title = $xml->getUniqueTag('encoded_title');
        $article->title = $xml->getUniqueTag('title');
        return $article;
    }
    
    

}
