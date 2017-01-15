<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArticleEntity
 *
 * @author Toss
 */
class ArticleEntity
{

    public $id;
    public $content;
    public $title;
    public $creationDate;
    public $encoded_title;
    
    public $exist = false;
    
    private static $postsPath;

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

    public static function countAllArticles()
    {
        if (!isset(self::$postsPath))
        {
            self::initPaths();
        }
        $files = glob(self::$postsPath . DS . '*-*-*.xml');
        return count($files);
    }
    
    private static function initPaths()
    {
        self::$postsPath = CONTENT_PATH;
    }
    
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
