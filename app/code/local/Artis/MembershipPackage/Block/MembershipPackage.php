<?php
class Artis_MembershipPackage_Block_MembershipPackage extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getMembershipPackage()     
     { 
        if (!$this->hasData('membershippackage')) {
            $this->setData('membershippackage', Mage::registry('membershippackage'));
        }
        return $this->getData('membershippackage');
        
    }
}