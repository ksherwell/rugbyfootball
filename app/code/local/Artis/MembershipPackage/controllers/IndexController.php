<?php
class Artis_MembershipPackage_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/membershippackage?id=15 
    	 *  or
    	 * http://site.com/membershippackage/id/15 	
    	 */
    	/* 
		$membershippackage_id = $this->getRequest()->getParam('id');

  		if($membershippackage_id != null && $membershippackage_id != '')	{
			$membershippackage = Mage::getModel('membershippackage/membershippackage')->load($membershippackage_id)->getData();
		} else {
			$membershippackage = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($membershippackage == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$membershippackageTable = $resource->getTableName('membershippackage');
			
			$select = $read->select()
			   ->from($membershippackageTable,array('membershippackage_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$membershippackage = $read->fetchRow($select);
		}
		Mage::register('membershippackage', $membershippackage);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}