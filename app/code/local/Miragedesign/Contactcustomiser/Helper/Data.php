<?php
/**
 * Miragedesign Web Development
 *
 * @category    Miragedesign
 * @package     Miragedesign_Contactcustomiser
 * @copyright   Copyright (c) 2011 Miragedesign (http://miragedesign.net)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Miragedesign_Contactcustomiser_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getSiteKey()
    {
        return $this->getConfig('site_key');
    }

    public function getSecretKey()
    {
        return $this->getConfig('secret_key');
    }

    public function isEnabled()
    {
        return $this->getConfig('enabled', false);
    }

    public function getConfig($field, $default = '', $section = 'contactcustomiser_captcha', $root = 'contacts')
    {
        $storeId = Mage::app()->getStore()->getId();
        $value = Mage::getStoreConfig($root . '/' .$section .  '/' . $field, $storeId);

        if (empty($value)) {
            return $default;
        }

        return $value;
    }
}
