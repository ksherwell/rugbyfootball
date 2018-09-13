<?php
class Artis_Salesforceconnect_Block_Salesforceconnect extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getSalesforceconnect()     
     { 
        if (!$this->hasData('salesforceconnect')) {
            $this->setData('salesforceconnect', Mage::registry('salesforceconnect'));
        }
        return $this->getData('salesforceconnect');
        
    }
}