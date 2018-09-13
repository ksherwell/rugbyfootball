<?php
class Artis_Salesforceconnect_Block_Adminhtml_Salesforceconnect extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_salesforceconnect';
    $this->_blockGroup = 'salesforceconnect';
    $this->_headerText = Mage::helper('salesforceconnect')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('salesforceconnect')->__('Add Item');
    parent::__construct();
  }
}