<?php

    //error_reporting(E_ALL);
    //ini_set('display_errors', 'On');

    function getSalesforceMemberByEmail($email) {

        $member = false;

        define("USERNAME", "eranda@mmr.com.au");
        define("PASSWORD", "hpi2010AFO");
        define("SECURITY_TOKEN", "3nia3ytYeq3PGXH4k5GJOdf9");
        
        require_once ('soapclient/SforcePartnerClient.php');
        
        $mySforceConnection = new SforcePartnerClient();
        $mySforceConnection->createConnection("soapclient/partner.wsdl.xml");
        $mySforceConnection->login(USERNAME, PASSWORD);
        
        $email = addslashes($email);

        $query = "SELECT Id, Name, Member__r.FirstName, Member__r.LastName, Member__r.Email, Status__c, ClubName__c, Address__c, Billing_Country__c, Billing_State_Province__c, Billing_Suburb_City__c, Billing_Zip_Postal_Code__c FROM Membership__c WHERE Member__r.Email = '".$email."'";
        //echo $query; exit;
        $response = $mySforceConnection->query($query);
    
        $num_records = count($response->records);
    
        if( $num_records > 0 ) :
        
    		$ids=array();
    		foreach ($response->records as $record) {
    			array_push($ids, $record->Id[0]);
    		}
    
    		// $ids is an array of record ids built in the previous step
    		$retrieve_fields = 'Id, Name, Member__r.FirstName, Member__r.LastName, Member__r.Email, Status__c, ClubName__c, Address__c, Billing_Country__c, Billing_State_Province__c, Billing_Suburb_City__c, Billing_Zip_Postal_Code__c';
    		$retrieve_object = 'Membership__c';
    		$response = $mySforceConnection->retrieve($retrieve_fields, $retrieve_object, $ids);
    
            //print_r($response); exit;
    
            if( count($response) > 0 ) :
    
                $get_member = $response[0];
    
                //print_r($get_member); exit;
    
                $member = $get_member->fields;

            endif;
    
            //print_r($member); exit;
    
        endif;

        return $member;

    }

    $sf_member = getSalesforceMemberByEmail($_GET['email']);

    print_r($sf_member); exit;
