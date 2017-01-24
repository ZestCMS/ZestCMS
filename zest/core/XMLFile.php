<?php

/**
 * XMLFile
 * 
 * Simple class for help to load and build XML files
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/MaxenceCauderlier/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */
class XMLFile
{
    /** @var string Full path of the file */
    private $filename;
    
    /** @var bool   If the file exist or not */
    private $file_exist = false;
    
    /** @var \DOMDocument File */
    private $xml;
    
    /**
     * Create a new XMLFile.
     * If the file exist, content is automaticaly taken
     * 
     * @param string Full path of the file
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->preserveWhiteSpace = true;
        $xml->formatOutput = true;
        if (is_file($filename))
        {
            $xml->load($filename);
            $this->file_exist = true;
        }
        $this->xml = $xml;
    }
    
    /**
     * Get a value for which a tag is unique on the file.
     * If the tag is not unique, the first occurence is returned.
     * 
     * @param string    Tag name
     * @return string   Value
     */
    public function getUniqueTag($tag)
    {
        return $this->xml->getElementsByTagName($tag)->item(0)->nodeValue;
    }
    
    /**
     * 
     * @return \DOMDocument
     */
    public function &getXML()
    {
        return $this->xml;
    }
    
    public function save()
    {
        $this->xml->save($this->filename);
    }
}
