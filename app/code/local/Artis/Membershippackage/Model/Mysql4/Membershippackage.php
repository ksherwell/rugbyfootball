<?php

class Artis_Membershippackage_Model_Mysql4_Membershippackage extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the membershippackage_id refers to the key field in your database table.
        $this->_init('membershippackage/membershippackage', 'membershippackage_id');
    }
}