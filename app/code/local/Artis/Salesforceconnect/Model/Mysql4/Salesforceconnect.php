<?php

class Artis_Salesforceconnect_Model_Mysql4_Salesforceconnect extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the salesforceconnect_id refers to the key field in your database table.
        $this->_init('salesforceconnect/salesforceconnect', 'salesforceconnect_id');
    }
}