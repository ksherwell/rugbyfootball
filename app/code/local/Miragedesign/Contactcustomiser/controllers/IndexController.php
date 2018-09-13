<?php
/**
 * Miragedesign Web Development
 *
 * @category    Miragedesign
 * @package     Miragedesign_Contactcustomiser
 * @copyright   Copyright (c) 2011 Miragedesign (http://miragedesign.net)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
require_once dirname(dirname(__FILE__)) . DS . 'Library' . DS . 'autoload.php';
require_once 'Mage/Contacts/controllers/IndexController.php';

use \ReCaptcha\ReCaptcha;

class Miragedesign_Contactcustomiser_IndexController extends Mage_Contacts_IndexController
{
    public function postAction()
    {
        $post = $this->getRequest()->getPost();

        if ( $post ) {
            $translate = Mage::getSingleton('core/translate');
            /* @var $translate Mage_Core_Model_Translate */
            $translate->setTranslateInline(false);
            $contactHelper = Mage::helper('contactcustomiser');
            $secret = $contactHelper->getSecretKey();

            try {
                $postObject = new Varien_Object();
                $postObject->setData($post);

                $errorMsg = '';

                $error = false;

                if (!Zend_Validate::is(trim($post['name']) , 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['comment']) , 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
                    $error = true;
                }

                if (Zend_Validate::is(trim($post['hideit']), 'NotEmpty')) {
                    $error = true;
                }

                if ($contactHelper->isEnabled()) {
                    $captcha = trim($post['g-recaptcha-response']);

                    if (!Zend_Validate::is($captcha , 'NotEmpty')) {
                        $error = true;
                        $errorMsg = $contactHelper->__('Please choose your captcha.');
                    }

                    $recaptcha = new \ReCaptcha\ReCaptcha($secret);

                    $resp = $recaptcha->verify($captcha, $_SERVER['REMOTE_ADDR']);

                    if (!$resp->isSuccess()) {
                        $error = true;
                        $errorMsg = $contactHelper->__('Invalid captcha.');
                    }
                }

                if ($error) {
                    throw new Exception($errorMsg);
                }

                $mailTemplate = Mage::getModel('core/email_template');
                /* @var $mailTemplate Mage_Core_Model_Email_Template */
                $mailTemplate->setDesignConfig(array('area' => 'frontend'))
                    ->setReplyTo($post['email'])
                    ->sendTransactional(
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT),
                        null,
                        array('data' => $postObject)
                    );

                if (!$mailTemplate->getSentSuccess()) {
                    throw new Exception();
                }

                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addSuccess(Mage::helper('contacts')->__('Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.'));
                $this->_redirect('*/*/');

                return;
            } catch (Exception $e) {
                $translate->setTranslateInline(true);

                if ($e->getMessage()) {
                    Mage::getSingleton('customer/session')->addError($e->getMessage());
                } else {
                    Mage::getSingleton('customer/session')->addError(Mage::helper('contacts')->__('Unable to submit your request. Please, try again later'));
                }

                $this->_redirect('*/*/');
                return;
            }

        } else {
            $this->_redirect('*/*/');
        }
    }
}
