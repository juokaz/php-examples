<?php

class App_Filter_Purifier_HtmlBody extends App_Filter_Purifier
{
    public function __construct($newOptions = null)
    {
        $options = array(
            array('HTML', 'Doctype', 'XHTML 1.0 Strict'),
            array('HTML', 'Allowed',
                'p,em,h1,h2,h3,h4,h5,strong,a[href],ul,ol,li,code,pre,'
                .'blockquote,img[src|alt|height|width],sub,sup,table,tr,td'
            ),
            array('AutoFormat', 'Linkify', 'true'),
        );

        // merge options
        if (!is_null($newOptions))
        {
            $options = array_merge($options, $newOptions);
        }

        parent::__construct($options);
    }
}