<?php

/**
 * TinyMce form element
 *
 * @original http://steven.macintyre.name/zend-framework-tinymce-view-helper/
 */
class App_Form_Element_TinyMce extends Zend_Form_Element_Textarea
{
    /**
     * Use formTinyMce view helper by default
     * @var string
     */
    public $helper = 'formTinyMce';

    public function init() {

        parent::init();

        $theme = array(
            'theme' => 'advanced',
            'theme_advanced_buttons1' => "bold,italic,underline,separator,anchor,image,separator,bullist,numlist,separator,undo,redo,separator,tablecontrols,separator,cleanup,code",
            'theme_advanced_buttons2' => '',
            'theme_advanced_buttons3' => '',
            'theme_advanced_toolbar_location' => "top",
            'theme_advanced_toolbar_align' => "center",
            'theme_advanced_statusbar_location' => "bottom",
            'theme_advanced_resizing' => "true",
        );

        $this->setOptions(array('editorOptions' => 
            array('plugins' => 'table') + $theme)
            );
    }
}
