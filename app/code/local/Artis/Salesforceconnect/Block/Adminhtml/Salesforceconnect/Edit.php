<?php

class Artis_Salesforceconnect_Block_Adminhtml_Salesforceconnect_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'salesforceconnect';
        $this->_controller = 'adminhtml_salesforceconnect';
        
        $this->_updateButton('save', 'label', Mage::helper('salesforceconnect')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('salesforceconnect')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('salesforceconnect_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'salesforceconnect_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'salesforceconnect_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('salesforceconnect_data') && Mage::registry('salesforceconnect_data')->getId() ) {
            return Mage::helper('salesforceconnect')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('salesforceconnect_data')->getTitle()));
        } else {
            return Mage::helper('salesforceconnect')->__('Add Item');
        }
    }
}