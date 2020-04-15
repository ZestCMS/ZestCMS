<?php

/*
 * Confirmation
 * 
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Utils;

/**
 * This class let you ask at the user if the required action is really wanted
 * with a javascript (Fancybox) alert
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */
class Confirmation {

    protected $lang;
    
    public $id;
    protected $buttons;
    public $text;
    public $title;
    public $yesBtnUrl;
    public $noBtnUrl;
    public $href;
    
    public $yesBtn;
    public $noBtn;
    
    public $hasNoBtnUrl;

    const BTN_YES_NO = 'yes-no';
    const BTN_OK_CANCEL = 'ok_cancel';

    public function __construct($title, $text, $buttons, $yesBtnUrl, $noBtnUrl, $id = false) {
        if ($id === false){
            $this->id = uniqid();
        } else {
            $this->id = $id;
        }
        $this->title = $title;
        $this->text = $text;
        $this->buttons = $buttons;

        $this->yesBtnUrl = $yesBtnUrl;
        $this->noBtnUrl = $noBtnUrl;
        
        $this->href = 'javascript:;';
        
        $this->prepareToScript();
        
    }
    
    protected function prepareToScript() {
        $this->lang = \Zest\Core\Zest::getInstance()->lang;
        if ($this->buttons === self::BTN_OK_CANCEL) {
            $this->yesBtn   = $this->lang->ok;
            $this->noBtn    = $this->lang->cancel;
        } elseif ($this->buttons === self::BTN_YES_NO) {
            $this->yesBtn   = $this->lang->yes;
            $this->noBtn    = $this->lang->no;
        }
        
        if ($this->noBtnUrl === false){
            $this->hasNoBtnUrl = false;
        } else {
            $this->hasNoBtnUrl = true;
        }
    }

    public function __toString() {
        $tpl = new \Zest\Templates\Template('confirmation.tpl');
        $tpl->set('CONFIRM', $this);
        return $tpl->output();
    }

}
