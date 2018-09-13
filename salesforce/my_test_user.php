<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

/*
    define("USERNAME", "artis.test70@gmail.com");
    define("PASSWORD", "option123");
    define("SECURITY_TOKEN", "sdfhkjwrhgfwrgergp");
*/

    define("USERNAME", "n1@mmr.com.au");
    define("PASSWORD", "hpi2010AFO");
    //define("SECURITY_TOKEN", "FFht9JEnPWXcQZBMEkWvFG3A");
    
    require_once ('soapclient/SforcePartnerClient.php');
    
    $mySforceConnection = new SforcePartnerClient();
    $mySforceConnection->createConnection("soapclient/partner.wsdl.xml");
    $mySforceConnection->setEndpoint('https://test.salesforce.com/services/Soap/u/20.0');
    $mySforceConnection->login(USERNAME, PASSWORD);
    
/*
    $query = "SELECT Id, FirstName, LastName, Phone from Contact";
    //$query = "SELECT Id, Email from Membership";
    $response = $mySforceConnection->query($query);

    print_r($response); exit;
*/

/*
    echo "Results of query '$query'<br/><br/>\n";
    foreach ($response->records as $record) {
        print_r($record);
        //echo $record->Id . ": " . $record->FirstName . " "
        //    . $record->LastName . " " . $record->Phone . "<br/>\n";
    }
*/



?>
