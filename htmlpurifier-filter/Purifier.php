<?php

class App_Filter_Purifier implements Zend_Filter_Interface
{
    /**
     * HTMLPurifier instance
     *
     * @var HTMLPurifier
     */
    protected $_htmlPurifier = null;

    /**
     * HTMLPuriifer filter
     *
     * @param array $newOptions
     */
    public function __construct(array $newOptions = array())
    {
        defined('HTMLPURIFIER_PREFIX') || define('HTMLPURIFIER_PREFIX', APPLICATION_PATH . '/../library');

        $config = null;

        $options = array(
            array('Cache', 'SerializerPath',
                APPLICATION_PATH . '/../cache/htmlpurifier'
            ),
            array('Core', 'Encoding', 
                'UTF-8')
            );

        // merge options
        if (!is_null($newOptions))
        {
            $options = array_merge($options, $newOptions);
        }

        // default options
        $config = HTMLPurifier_Config::createDefault();
        
        if (!is_null($options))
        {
            foreach ($options as $option) {
                $config->set($option[0] . '.' . $option[1], $option[2]);
            }
        }
        
        $this->_htmlPurifier = new HTMLPurifier($config);
    }

    /**
     * Filter value
     *
     * @param string $value
     * @return string
     */
    public function filter($value) {
        
        return $this->_htmlPurifier->purify($value);
    }
}