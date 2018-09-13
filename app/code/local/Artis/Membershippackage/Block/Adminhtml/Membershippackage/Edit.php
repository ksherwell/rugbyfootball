<?php

class Artis_Membershippackage_Block_Adminhtml_Membershippackage_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'membershippackage';
        $this->_controller = 'adminhtml_membershippackage';
        
        $this->_updateButton('save', 'label', Mage::helper('membershippackage')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('membershippackage')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('membershippackage_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'membershippackage_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'membershippackage_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('membershippackage_data') && Mage::registry('membershippackage_data')->getId() ) {
            return Mage::helper('membershippackage')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('membershippackage_data')->getTitle()));
        } else {
            return Mage::helper('membershippackage')->__('Add Item');
        }
    }
}