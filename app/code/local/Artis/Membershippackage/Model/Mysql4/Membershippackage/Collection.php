<?php

class Artis_Membershippackage_Model_Mysql4_Membershippackage_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('membershippackage/membershippackage');
    }
}