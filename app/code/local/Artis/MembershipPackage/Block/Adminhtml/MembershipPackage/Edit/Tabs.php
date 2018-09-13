<?php

class Artis_MembershipPackage_Block_Adminhtml_MembershipPackage_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('membershippackage_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('membershippackage')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('membershippackage')->__('Item Information'),
          'title'     => Mage::helper('membershippackage')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('membershippackage/adminhtml_membershippackage_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}