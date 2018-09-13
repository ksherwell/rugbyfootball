<?php

class Artis_MembershipPackage_Model_Mysql4_MembershipPackage extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the membershippackage_id refers to the key field in your database table.
        $this->_init('membershippackage/membershippackage', 'membershippackage_id');
    }
}