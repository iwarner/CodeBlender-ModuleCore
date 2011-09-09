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
 */
class Core_SitemapController extends Zend_Controller_Action
{

    /**
     * Provides a simple form for the users to contact us.
     *
     * @return object
     */
    public function indexAction()
    {
        // Config
        $this->view->config = $this->getInvokeArg('bootstrap')->getOptions();
    }

    /**
     * Action to allow the user to download the XML formatted sitemap
     *
     * @return void
     */
    public function downloadAction()
    {
        // Set the script to not render to any view
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        // Set the content type of this page1 to PDF
        $this->getResponse()->setHeader('Content-Type', 'text/xml');
        $this->getResponse()->setHeader('Content-Disposition', 'attachment; filename="SiteMap.xml"');

        echo Zend_Registry::get('nav')->sitemap()->setFormatOutput(true);
    }

}
