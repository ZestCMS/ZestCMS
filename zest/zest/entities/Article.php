<?php

/**
 * Article
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Entities;

/**
 * Article Entity
 */
class Article implements \JsonSerializable
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
     * Article encoded title, used to access this article
     * @var string
     */
    public $encoded_title;

    /**
     * Article parsed Content
     * @var string
     */
    public $htmlContent;

    /**
     * Accessible URL Article
     * @var string
     */
    public $url;

    /**
     * Hydrate an article with an array
     *
     * @param array Values
     */
    public function hydrateByArray($arr)
    {
        $this->title         = $arr['title'];
        $this->encoded_title = $arr['encoded_title'];
        if (isset($arr['creation']) && $arr['creation'] !== '') {
            $this->creation = $arr['creation'];
        }
        else {
            $this->creation = time();
        }

        $this->date = \Zest\Utils\ArticleHelper::date_format($this->creation);
        if (isset($arr['id']) && is_numeric($arr['id']) && $arr['id'] >= 0) {
            $this->id = $arr['id'];
        }
        $this->content = $arr['content'];
        if (isset($arr['htmlContent'])) {
            $this->htmlContent = $arr['htmlContent'];
        }
        else {
            $this->htmlContent = \Zest\Core\Zest::getInstance()->getParser()->parse($this->content);
        }
        $this->url = ROOT_URL . 'articles/' . $this->encoded_title;
    }

    /**
     * Function to serialize Article into JSON and keep only needed informations
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'encoded_title' => $this->encoded_title,
            'creation'      => $this->creation
        ];
    }

    /**
     * Check if an article is valid and ready to be saved
     *
     * @return Boolean
     */
    public function isValid()
    {
        return (isset($this->content) && isset($this->creation) && isset($this->encoded_title) && isset($this->title));
    }

    public function save()
    {
        if (!isset($this->id)) {
            // New article
            $this->id = \Zest\Managers\Articles::getMaxID() + 1;
        }
        \Zest\Managers\Articles::saveArticle($this);
    }

}
