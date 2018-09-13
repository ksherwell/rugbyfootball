<?php

class Artis_MembershipPackage_Block_Adminhtml_MembershipPackage_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('membershippackage_form', array('legend'=>Mage::helper('membershippackage')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('membershippackage')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('membershippackage')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('membershippackage')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('membershippackage')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('membershippackage')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('membershippackage')->__('Content'),
          'title'     => Mage::helper('membershippackage')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getMembershipPackageData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getMembershipPackageData());
          Mage::getSingleton('adminhtml/session')->setMembershipPackageData(null);
      } elseif ( Mage::registry('membershippackage_data') ) {
          $form->setValues(Mage::registry('membershippackage_data')->getData());
      }
      return parent::_prepareForm();
  }
}