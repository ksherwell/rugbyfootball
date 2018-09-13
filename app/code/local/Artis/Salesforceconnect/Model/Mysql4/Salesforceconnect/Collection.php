<?php

class Artis_Salesforceconnect_Model_Mysql4_Salesforceconnect_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('salesforceconnect/salesforceconnect');
    }
}