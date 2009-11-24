<?php

/**
 * Doctrine application resource
 *
 * @author Juozas Kaziukenas (juozas@juokaz.com)
 */
class App_Application_Resource_Doctrine extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * Initialize
     */
    public function init()
    {
        $doctrineConfig = $this->getOptions();

        if (isset($doctrineConfig['compiled']) && $doctrineConfig['compiled'] == true &&
            file_exists(APPLICATION_PATH . '/../library/Doctrine.compiled.php'))
        {
            require_once 'Doctrine.compiled.php';
        }
        else
        {
            require_once 'Doctrine.php';
        }

        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->pushAutoloader(array('Doctrine_Core', 'autoload'), 'Doctrine');

        $manager = Doctrine_Manager::getInstance();

        // set models to be autoloaded and not included (Doctrine_Core::MODEL_LOADING_AGGRESSIVE)
        $manager->setAttribute(
            Doctrine_Core::ATTR_MODEL_LOADING,
            Doctrine_Core::MODEL_LOADING_CONSERVATIVE
        );

        // enable ModelTable classes to be loaded automatically
        $manager->setAttribute(
            Doctrine_Core::ATTR_AUTOLOAD_TABLE_CLASSES,
            true
        );

        // enable validation on save()
        $manager->setAttribute(
            Doctrine_Core::ATTR_VALIDATE,
            Doctrine_Core::VALIDATE_ALL
        );

        // enable sql callbacks to make SoftDelete and other behaviours work transparently
        $manager->setAttribute(
            Doctrine_Core::ATTR_USE_DQL_CALLBACKS,
            true
        );

        // enable automatic queries resource freeing
        $manager->setAttribute(
            Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS,
            true
        );

        // connect to database
        $manager->openConnection($doctrineConfig['connection_string']);

        // set to utf8
        $manager->connection()->setCharset('utf8');

        if (isset($doctrineConfig['cache']) && $doctrineConfig['cache'] == true)
        {
            $cacheDriver = new Doctrine_Cache_Apc();

            $manager->setAttribute(
                Doctrine_Core::ATTR_QUERY_CACHE,
                $cacheDriver
            );
        }

        return $manager;
    }
}