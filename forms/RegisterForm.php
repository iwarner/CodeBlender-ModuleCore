<?php

/**
 * CodeBlender
 *
 * @category  CodeBlender
 * @package   Core
 * @copyright Copyright (c) 2011 Triangle Solutions Ltd. (http://www.triangle-solutions.com/)
 * @license   http://codeblender.net/license
 */

/**
 * Form
 *
 * @category  CodeBlender
 * @package   Core
 * @copyright Copyright (c) 2011 Triangle Solutions Ltd. (http://www.triangle-solutions.com/)
 * @license   http://codeblender.net/license
 */
class Core_Form_RegisterForm extends Zend_Form
{

    /**
     * Init
     */
    public function init()
    {
        // Set general properties of the form
        $this->setName('registerForm')
                ->setAction('/core/register')
                ->setMethod('post');

        // registerFirstName Element - ValidationTextBox
        $this->addElement('text', 'registerFirstName', array(
            'label' => 'First Name *',
            'required' => true,
            'trim' => true
        ));

        // registerLastName Element - ValidationTextBox
        $this->addElement('text', 'registerLastName', array(
            'label' => 'Last Name *',
            'required' => true,
            'trim' => true
        ));

        // personal Group
        $this->addDisplayGroup(
                array('registerFirstName', 'registerLastName'), 'personal', array('legend' => 'Personal Details')
        );

        // registerEmail Element - ValidationTextBox
        $this->addElement('text', 'registerEmail', array(
            'filters' => array('StringToLower'),
            'label' => 'Email *',
            'required' => true,
            'trim' => true,
            'validators' => array('EmailAddress', array('StringLength', false, 4))
        ));

        // registerPassword Element - PasswordTextBox
        $this->addElement('password', 'registerPassword', array(
            'label' => 'Password *',
            'regExp' => '^[a-zA-Z0-9_]{6,20}$',
            'required' => true,
            'trim' => true,
            'validators' => array(new CodeBlender_Validate_Confirm('registerPasswordConfirm'))
        ));

        // registerPasswordConfirm Element - PasswordTextBox
        $this->addElement('password', 'registerPasswordConfirm', array(
            'label' => 'Confirm Password *',
            'regExp' => '^[a-zA-Z0-9_]{6,20}$',
            'required' => true,
            'trim' => true
        ));

        // Credentials Group
        $this->addDisplayGroup(
                array('registerEmail', 'registerPassword', 'registerPasswordConfirm'), 'credentials', array('legend' => 'User Credentials')
        );

        // registerTerms Element - CheckBox
        $this->addElement('checkbox', 'registerTerms', array(
            'label' => 'Terms And Conditions *',
            'required' => true,
            'trim' => true
        ));

        // Set the main Description
        $this->registerTerms->setDescription('You must agree to the <a href="/terms" title="Terms and Conditions" target="_new">Terms and Conditions.</a> to register.');
        $this->registerTerms->setDecorators(array(
            array('ViewHelper'),
            array('Errors'),
            array('HtmlTag', array('tag' => 'dd')),
            array('Label', array('tag' => 'dt')),
            array('Description', array('tag' => '<br />', 'closeOnly' => true, 'escape' => false, 'placement' => 'append')),
        ));

        // registerSubmit Element - submitButton
        $this->addElement('submit', 'registerSubmit', array(
            'ignore' => true,
            'label' => 'Register',
            'required' => false
        ));

        $this->registerSubmit->setDescription('<br /><a href="/core/forgotdetails" title="Lost Account Details">Lost Account Details?</a>');
        $this->registerSubmit->addDecorators(array(
            array('Description', array('escape' => false, 'placement' => 'append')),
            array('HtmlTag', array('tag' => 'div', 'class' => 'submit'))
        ));

        // policies Group
        $this->addDisplayGroup(
                array('registerTerms', 'registerSubmit'), 'policies', array('legend' => 'Site Policies')
        );
    }

}
