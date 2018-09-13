<?php

class Artis_MembershipPackage_Model_MembershipPackage extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('membershippackage/membershippackage');
    }
}