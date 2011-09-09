<?php

/**
 * CodeBlender
 *
 * @category  CodeBlender
 * @package   Core
 * @copyright Copyright (c) 2000-2011 Triangle Solutions Ltd. (http://www.triangle-solutions.com/)
 * @license   http://codeblender.net/license
 */

/**
 * Controller
 *
 * @category  CodeBlender
 * @package   Core
 * @copyright Copyright (c) 2000-2011 Triangle Solutions Ltd. (http://www.triangle-solutions.com/)
 * @license   http://codeblender.net/license
 *
 * @todo Does this work if no session or cache is available - test and fix
 */
class Core_CacheController extends Zend_Controller_Action
{

    /**
     * Action
     */
    public function indexAction()
    {
        $cache = $this->_helper->cache->getCache('codeblender');
        $cache->clean(Zend_Cache::CLEANING_MODE_ALL);

        // Clean the session
        Zend_Session::namespaceUnset(CODEBLENDER_SITENAME);
    }

}
