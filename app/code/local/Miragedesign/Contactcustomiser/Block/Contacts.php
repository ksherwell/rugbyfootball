<?php
/**
 * Miragedesign Web Development
 *
 * @category    Miragedesign
 * @package     Miragedesign_Contactcustomiser
 * @copyright   Copyright (c) 2011 Miragedesign (http://miragedesign.net)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Miragedesign_Contactcustomiser_Block_Contacts extends Mage_Core_Block_Template
{
    protected $_lang = null;

    public function getSiteKey()
    {
        return Mage::helper('contactcustomiser')->getSiteKey();
    }

    public function getLang()
    {
        if (!$this->_lang) {
            $this->_lang = substr(Mage::app()->getLocale()->getLocaleCode(), 0, 2);
        }
        return $this->_lang;
    }

    public function isCaptchaEnabled()
    {
        return Mage::helper('contactcustomiser')->isEnabled();
    }
}