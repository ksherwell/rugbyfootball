<?php

class Artis_Membershippackage_Model_Membershippackage extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('membershippackage/membershippackage');
    }
}