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
    public $creation;
    
    /**
     * Article Date creation
     * @var int
     */
    public $creationDate;
    
    /**
     * Article encoded title, used to access this article
     * @var string
     */
    public $encoded_title;
    
    /**
     * Article Url, defined by his encoded_title
     * @var string Url
     */
    public $url;
    
    /**
     * Article exist ?
     * true  : Article is already written in file
     * false : Article has no file
     * @var boolean
     */
    public $exist = false;
    
    /**
     * Article full path & filename
     * @var string
     */
    public $filename;
    
    /**
     * Articles files path
     * @var string
     */
    private static $postsPath;
    
    public function __construct()
    {
        if (!isset(self::$postsPath))
        {
            self::initPaths();
        }
    }

    /**
     * Hydrate an article with an array
     * 
     * @param array Values
     */
    public function hydrateByArray($arr)
    {
        $this->title = $arr['title'];
        $this->encoded_title = $arr['encoded_title'];
        if (isset($arr['creation']) && $arr['creation'] !== '')
        {
            $this->creation = $arr['creation'];
        }
        else
        {
            $this->creation = time();
        }
        if (isset($arr['id']) && is_numeric($arr['id']) && $arr['id'] >= 0)
        {
            $this->id = $arr['id'];
        }
        var_dump($this->id);
        $this->content = $arr['content'];
    }
    
    /**
     * Check if an article is valid and ready to be saved
     * 
     * @return Boolean
     */
    public function isValid()
    {
        return (isset($this->content) && isset($this->creation)
                && isset($this->encoded_title) && isset($this->title));
    }
    
    /**
     * Save the article in a XML file
     * 
     * @return int  Article ID
     */
    public function save()
    {
        if (!isset($this->id))
        {
            // New article
            $this->id = self::getMaxID() + 1;
            $this->writeFile();
            $this->exist = true;
        }
        else
        {
            // Edit article
            $files = glob(self::$postsPath . DS . $this->id .'-*-*'. '.xml');
            if ($files[0] !== false)
            {
                unlink($files[0]);
            }         
            $this->writeFile();            
        }
        return $this->id;
    }
    
    /**
     * Save the new article in a XML file, with filename like this :
     * Postspath/ID-Timestamp-Encoded_Title.xml
     */
    private function writeFile()
    {
        $this->filename = self::$postsPath . $this->id . '-' . $this->creation . '-' . $this->encoded_title . '.xml';
        $xmlfile = new XMLFile($this->filename);
        $xml = &$xmlfile->getXML();
        $root = $xml->appendChild($xml->createElement("root"));
        $id = $root->appendChild($xml->createElement("id", $this->id));
        $creation = $root->appendChild($xml->createElement("creation", $this->creation));
        $title = $root->appendChild($xml->createElement("title"));
        $title->appendChild($xml->createCDATASection($this->title));
        $encoded_title = $root->appendChild($xml->createElement("encoded_title", $this->encoded_title));
        $content = $root->appendChild($xml->createElement("content"));
        $content->appendChild($xml->createCDATASection($this->content));
        $xmlfile->save();  
    }
    
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

        $files = glob(self::$postsPath . '*-*-' . $name . '.xml');
        if (empty($files))
        {
            return false;
        }
        $article = self::loadByFilename($files[0]);
        return $article;
    }
    
    /**
     * Get an article by his ID
     * 
     * @param string Article ID
     * @return \self
     */
    public static function getArticleByID($id)
    {
        if (!isset(self::$postsPath))
        {
            self::initPaths();
        }
        $files = glob(self::$postsPath . DS . $id .'-*-*'. '.xml');
        if (empty($files))
        {
            return false;
        }
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
        // Sort by timestamp DESC
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
     * Get all articles
     * 
     * @return array    Array with Articles
     */
    public static function getAllArticles()
    {
        if (!isset(self::$postsPath))
        {
            self::initPaths();
        }
        $files = glob(self::$postsPath . DS . '*-*-*.xml');
        $art = [];
        foreach ($files as $file)
        {
            $art[] = self::loadByFilename($file);
        }
        return $art;
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
        $article->creation = $xml->getUniqueTag('creation');
        $article->creationDate = date('d/m/Y', $xml->getUniqueTag('creation'));
        $article->content = $xml->getUniqueTag('content');
        $parser = new ParsedownExtra();
        $article->htmlContent = $parser->text($article->content);
        $article->encoded_title = $xml->getUniqueTag('encoded_title');
        $article->title = $xml->getUniqueTag('title');
        $article->url = Zest::getInstance()->getRootUrl() .'articles/'. $article->encoded_title;
        $article->filename = $filename;
        return $article;
    }
    
    /**
     * Return the higher ID used by all articles
     * 
     * @return int Max ID
     */
    public static function getMaxID()
    {
        $files = glob(self::$postsPath . DS . '*-*-*.xml');
        $idmax = 0;
        foreach ($files as $file)
        {
            $id = self::getArticleInfo($file, 'id');
            if ($id > $idmax)
            {
                $idmax = $id;
            }
        }
        return $idmax;
    }
    
    /**
     * Get an article info contained in his filename
     * 
     * @param string    File name
     * @param string    Asked Info
     *   id : Article ID
     *   timestamp : Article Creation date
     *   enctitle : Encoded Title
     * @return type
     */
    public static function getArticleInfo($filename, $asked = 'id')
    {
        if (strpos($filename, DS) !== false)
        {
            $parts = explode(DS, $filename);
            $filename = array_pop($parts);
        }
        $infos = explode('-', $filename);
        $encoded_title = explode('.', $infos[2]);
        // Keep only the encoded title, no file extension
        $infos[2] = $encoded_title[0];
        if ($asked === 'id')
        {
            return $infos[0];
        }
        elseif ($asked === 'timestamp')
        {
            return $infos[1];
        }
        return $infos[2];
    }
    
    public function delete()
    {
        unlink($this->filename);
    }
}