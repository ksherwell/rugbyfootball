<?php
class Artis_Membershippackage_Block_Membershippackage extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getMembershippackage()     
     { 
        if (!$this->hasData('membershippackage')) {
            $this->setData('membershippackage', Mage::registry('membershippackage'));
        }
        return $this->getData('membershippackage');
        
    }
}