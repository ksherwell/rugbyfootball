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
    //$mySforceConnection->setEndpoint('https://test.salesforce.com/services/Soap/u/20.0');
    $mySforceConnection->login(USERNAME, PASSWORD);

    $scopeHeader = new LoginScopeHeader();
    $scopeHeader->portalId = "060900000000w4N";
    $scopeHeader->organizationId = "00DN000000035QI";

    $mySforceConnection->LoginScopeHeaderValue = $scopeHeader;

    $mySforceConnection->login(USERNAME, PASSWORD);


?>
