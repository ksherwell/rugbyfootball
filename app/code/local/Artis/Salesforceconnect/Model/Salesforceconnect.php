<?php

class Artis_Salesforceconnect_Model_Salesforceconnect extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('salesforceconnect/salesforceconnect');
    }
}