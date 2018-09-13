<?php
class Artis_Customtabs_Model_Observer
{
    /**
     * Flag to stop observer executing more than once
     *
     * @var static bool
     */
    static protected $_singletonFlag = false;
    /**
     * This method will run when the product is saved from the Magento Admin
     * Use this function to update the product model, process the
     * data or anything you like
     *
     * @param Varien_Event_Observer $observer
     */
    public function saveProductTabData(Varien_Event_Observer $observer)
    {
        if (!self::$_singletonFlag) {
            self::$_singletonFlag = true;
            $product = $observer->getEvent()->getProduct();
            
            //echo "<pre>";
            //print_r($this->_getRequest()->getPost('del_im'));
            //exit;
            
            foreach($this->_getRequest()->getPost('del_im') as $imid)
            {
                
                
                $temptableThreeSixtyImagesGrid=Mage::getSingleton('core/resource')->getTableName('three_sixty_images');
                $sqlThreeSixtyImagesGrid="select image_name from ".$temptableThreeSixtyImagesGrid." where id='".$imid."'";
                try {
                $chkThreeSixtyImagesGrid = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($sqlThreeSixtyImagesGrid);
                } catch (Exception $e){
                
                }
                
                $path = Mage::getBaseDir('media') . DS ."threesixtyimages". DS;
                if(@unlink($path.$chkThreeSixtyImagesGrid[0]["image_name"]));
                {
                    $temptableThreeSixtyImagesGrid=Mage::getSingleton('core/resource')->getTableName('three_sixty_images');
                    $sqlThreeSixtyImagesGrid="delete from ".$temptableThreeSixtyImagesGrid." where id='".$imid."'";
                    try {
                    $chkThreeSixtyImagesGrid = Mage::getSingleton('core/resource')->getConnection('core_read')->query($sqlThreeSixtyImagesGrid);
                    } catch (Exception $e){
                    
                    } 
                    
                }
                
                
                
            }
            
            
            
            
            
            
            
            try {
                /**
                 * Perform any actions you want here
                 *
                 */
                
             
                try {
                        
                      $uploader = new Varien_File_Uploader('custom_image');
                      
                      
                      
                      $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything
                   
                   
                      $uploader->setAllowRenameFiles(false);
                   
                      // setAllowRenameFiles(true) -> move your file in a folder the magento way
                      // setAllowRenameFiles(true) -> move your file directly in the $path folder
                      $uploader->setFilesDispersion(false);
                     
                      $path = Mage::getBaseDir('media') . DS ."threesixtyimages". DS;
                     
                                 
                      $flg="";           
                      if($uploader->save($path, $_FILES['custom_image']['name']))
                      {
                        $flg="ok";
                      }
                      
                      
                        /*$_imageUrl=Mage::getBaseDir('media')."/".$col->getfilename();
                        $imageResized=Mage::getBaseDir('media')."/resized/".$col->getfilename();
                        $imageObj = new Varien_Image($_imageUrl);
                        $imageObj->constrainOnly(TRUE);
                        $imageObj->keepAspectRatio(TRUE);
                        $imageObj->keepFrame(FALSE);
                        //$imageObj->resize(null,138);
                        $imageObj->save($imageResized);
                        
                        $imageOriginal = Mage::getBaseUrl('media').$col->getfilename();
                        $imageResized = Mage::getBaseUrl('media').'resized/'.$col->getfilename();*/
                      
                      
                      
                   
                      //$data['fileinputname'] = $_FILES['fileinputname']['name'];
                      
                    }catch(Exception $e) {
                       // var_dump($e);
                    }
                    
                    if($this->_getRequest()->getPost('disp_ord')>0)
                    {
                        $disp_ord=$this->_getRequest()->getPost('disp_ord');
                    }
                    else
                    {
                        $disp_ord=0;
                    }
                    
                    if($_FILES['custom_image']['name']!="" && $flg=="ok")
                    {
                        $temptableThreeSixtyImagesGrid=Mage::getSingleton('core/resource')->getTableName('three_sixty_images');
                        $sqlThreeSixtyImagesGrid="insert into ".$temptableThreeSixtyImagesGrid." SET id='',product_id='".$product->getId()."',image_name='".$_FILES['custom_image']['name']."',display_order='".$disp_ord."'";
                        try {
                        $chkThreeSixtyImagesGrid = Mage::getSingleton('core/resource')->getConnection('core_write')->query($sqlThreeSixtyImagesGrid);
                        } catch (Exception $e){
                        //echo $e>getMessage();
                        }
                    }
                
             
                //$product->save();
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
    }
    /**
     * Retrieve the product model
     *
     * @return Mage_Catalog_Model_Product $product
     */
    public function getProduct()
    {
        return Mage::registry('product');
    }
    /**
     * Shortcut to getRequest
     *
     */
    protected function _getRequest()
    {
        return Mage::app()->getRequest();
    }
}