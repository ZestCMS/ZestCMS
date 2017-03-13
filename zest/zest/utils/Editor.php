<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Zest\Utils;

/**
 * Description of Editor
 *
 * @author Toss
 */
class Editor
{

    private $id;

    /**
     * Editor Template
     * @var \Zest\Templates\Template $template
     */
    private $template;
    private $postId;
    private $content;

    public function __construct($id)
    {
        $this->id       = 'editor_' . $id;
        $this->template = new \Zest\Templates\Template('editor.tpl');
        $this->postId   = $this->id . 'content';

        $this->content = isset($_POST[$this->postId]) ? $_POST[$this->postId] : false;
    }

    public function output()
    {
        $this->template->set('ID', $this->id);
        $this->before_editor = \Zest\Core\HookManager::execute_filter('add_content_to_editor', '', [
                    'textareaID' => $this->postId,
        ]);
        $this->template->set('CONTENT', $this->content);
        $this->template->set('before_editor', $this->before_editor);
        return $this->template->output();
    }

    public function getPOSTContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

}
