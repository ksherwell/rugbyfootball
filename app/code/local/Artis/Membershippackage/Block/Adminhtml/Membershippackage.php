<?php
class Artis_Membershippackage_Block_Adminhtml_Membershippackage extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_membershippackage';
    $this->_blockGroup = 'membershippackage';
    $this->_headerText = Mage::helper('membershippackage')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('membershippackage')->__('Add Item');
    parent::__construct();
  }
}