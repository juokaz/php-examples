<?php

class App_Filter_HtmlToText implements Zend_Filter_Interface
{
    /**
     * Transform html to text
     *
     * @param string $value
     * @return string
     */
    public function filter($value)
    {
        $filtered = $value;

        // replace ending text blocks
        $filtered = str_replace("</div>", "</div>\n", $filtered);
        $filtered = str_replace("</p>", "</p>\n\n", $filtered);

        // line breaks
        $filtered = str_replace("<br>", "<br>\n", $filtered);
        $filtered = str_replace("<br/>", "<br>\n", $filtered);
        $filtered = str_replace("<br />", "<br>\n", $filtered);

        // replace tabs to spaces
        $filtered = str_replace("\t", " ", $filtered);
        // replace repeating spaces
        $filtered = preg_replace("/( +)/", " ", $filtered);
        // replace repeating new lines
        $filtered = preg_replace("/(\n\r*){2,}/", "\n", $filtered);

        $filtered = strip_tags($filtered);

        return trim($filtered);
    }
}