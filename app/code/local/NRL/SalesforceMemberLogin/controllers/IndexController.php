<?php

    class NRL_SalesforceMemberLogin_IndexController extends Mage_Core_Controller_Front_Action {

        public function indexAction(){

            $action = (isset($_GET['action'])) ? $_GET['action'] : 'auth';

            if(isset($_GET['r']))
            {
                Mage::getSingleton('core/session')->setPanthersMemberLoginRedirect($_GET['r']);
            }

            require( Mage::getModuleDir('Helper', 'NRL_SalesforceMemberLogin') . '/Helper/NRL_Salesforce_Member_Authentication.class.php' );

            $SFAuth = new NRL_Salesforce_Member_Authentication(array(
                'client_id' => '3MVG9e2mBbZnmM6lxKNh7ziMbLby4hzbUKGdHguoO6KGOMbjWthpiPxWUOgphtNpcN9zSsuTh43J2OuvkKycM',
                'client_secret' => '8674266167508479641',
                'redirect_uri' => 'https://store.penrithpanthers.com.au/index.php/nrlmemberlogin',
                'endpoint_uri' => 'https://nrl--ArxxusDev.cs6.my.salesforce.com/'
            ));

            // return with message if class couldnt be loaded
            if( $SFAuth === false )
            {
                Mage::getSingleton('core/session')->addError('An unknown error occurred, please try again later.');
                $this->redirectUser();
            }

            // run auth action (default)
            if( $action == 'auth' )
            {

                // process oauth
                if( $SFAuth->doAuth() ) {

                    // retrieve authenticated user details
                    $user = $SFAuth->getUser();
                    print_r($user); exit;

                    // check if active member for correct club (BULLDOGS)
                    if( $user->Status__c == 'Active' && $user->ClubName__c == 'BULLDOGS' )
                    {
                        $this->createCustomer( $user );
                        Mage::getSingleton('core/session')->addSuccess('Welcome ' . $user->Member__r->fields->FirstName . ', you have been logged in.'); 
                    }
                    else
                    {
                        Mage::getSingleton('core/session')->addError('You are not an active Panthers member.');
                    }

                    // send user back to where they came from
                    $this->redirectUser();

                }
                else
                {
                    Mage::getSingleton('core/session')->addError('An unknown error occurred, please try again later.');
                }

            }

        }

        function redirectUser() {
            $custom_redirect = Mage::getSingleton('core/session')->getPanthersMemberLoginRedirect();
            $redirect = ($custom_redirect) ? $custom_redirect : '/';
            //echo $redirect; exit;
            //$this->_redirectUrl($redirect);
            header('Location: ' . $redirect); exit;
            exit;
        }

        function createCustomer($user) {

            //echo 'createCustomer';
            //print_r($user); exit;

            $customer = Mage::getModel('customer/customer');
            $customer->setWebsiteId( Mage::app()->getWebsite()->getId() );
            $customer->loadByEmail($user->email);

            if( !$customer->getId() ) {

                $customer->setEmail($user->email);
                $customer->setFirstname($user->Member__r->fields->FirstName);
                $customer->setLastname($user->Member__r->fields->LastName);
                $customer->setPassword($user->id);
                $customer->setData( 'group_id', 4 );
                $customer->save();

                // set customers address

                $_custom_address = array (
                    'firstname' => $user->Member__r->fields->FirstName,
                    'lastname' => $user->Member__r->fields->LastName,
                    'street' => array (
                        '0' => $user->Address__c
                    ),
                    'city' => $user->Billing_Suburb_City__c,
                    'region_id' => '',
                    'region' => $user->Billing_State_Province__c,
                    'postcode' => $user->Billing_Zip_Postal_Code__c,
                    'country_id' => 'AU',
                    'telephone' => '',
                );

                $customAddress = Mage::getModel('customer/address');
                $customAddress->setData($_custom_address)
                            ->setCustomerId($customer->getId())
                            ->setIsDefaultBilling('1')
                            ->setIsDefaultShipping('1');
                $customAddress->save();

                Mage::getSingleton('checkout/session')->getQuote()->setBillingAddress(Mage::getSingleton('sales/quote_address')->importCustomerAddress($customAddress));

            }

            $customer->setConfirmation(null);
            $customer->save();
            Mage::getSingleton('customer/session')->loginById($customer->getId());

        }

    }