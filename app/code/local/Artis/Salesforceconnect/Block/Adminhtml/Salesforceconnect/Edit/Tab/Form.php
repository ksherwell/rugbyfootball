<?php

class Artis_Salesforceconnect_Block_Adminhtml_Salesforceconnect_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('salesforceconnect_form', array('legend'=>Mage::helper('salesforceconnect')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('salesforceconnect')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('salesforceconnect')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('salesforceconnect')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('salesforceconnect')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('salesforceconnect')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('salesforceconnect')->__('Content'),
          'title'     => Mage::helper('salesforceconnect')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getSalesforceconnectData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getSalesforceconnectData());
          Mage::getSingleton('adminhtml/session')->setSalesforceconnectData(null);
      } elseif ( Mage::registry('salesforceconnect_data') ) {
          $form->setValues(Mage::registry('salesforceconnect_data')->getData());
      }
      return parent::_prepareForm();
  }
}