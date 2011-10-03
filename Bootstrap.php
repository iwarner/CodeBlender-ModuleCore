<?php

/**
 * CodeBlender
 *
 * @category  CodeBlender
 * @package   BootStrap
 * @copyright Copyright (c) 2011 Triangle Solutions Ltd. (http://www.triangle-solutions.com/)
 * @license   http://codeblender.net/license
 */

/**
 * Bootstrap script
 *
 * @category  CodeBlender
 * @package   BootStrap
 * @copyright Copyright (c) 2011 Triangle Solutions Ltd. (http://www.triangle-solutions.com/)
 * @license   http://codeblender.net/license
 */
class Core_Bootstrap extends Zend_Application_Module_Bootstrap
{

    /**
     * Bootstrap autoloader for application resources
     *
     * @return Zend_Application_Module_Autoloader
     */
    protected function _initCodeBlenderCoreAutoload()
    {
        // Set the auto load for the Default Module.
        $moduleLoader = new Zend_Application_Module_Autoloader(array(
                'namespace' => 'Core',
                'basePath' => APPLICATION_PATH . '/modules/core'
            ));

        return $moduleLoader;
    }

}
