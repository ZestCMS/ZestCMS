<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of XMLFile
 *
 * @author Toss
 */
class XMLFile
{
    private $filename;
    
    private $file_exist = false;
    
    private $xml;
    
    public function __construct($filename)
    {
        $this->filename = $filename;
        $xml = new DOMDocument();
        $xml->preserveWhiteSpace = true;
        $xml->formatOutput = true;
        if (is_file($filename))
        {
            $xml->load($filename);
            $this->file_exist = true;
        }
        $this->xml = $xml;
    }
    
    public function getUniqueTag($tag)
    {
        return $this->xml->getElementsByTagName($tag)->item(0)->nodeValue;
    }
}
