<?php

class Artis_Salesforceconnect_Block_Adminhtml_Salesforceconnect_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('salesforceconnect_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('salesforceconnect')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('salesforceconnect')->__('Item Information'),
          'title'     => Mage::helper('salesforceconnect')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('salesforceconnect/adminhtml_salesforceconnect_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}