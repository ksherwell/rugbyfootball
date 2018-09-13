<?php

class NRL_Salesforce_Member_Authentication {

    // define vars
    var $oauth = false;
    var $soap = false;
    var $options = false;
    var $helper_dir = '';

    // auth vars
    var $token = false;
    var $auth_response = false;
    var $authenticated = false;
    var $user = false;
    

    function __construct($custom_options) {

        $this->helper_dir = Mage::getModuleDir('Helper', 'NRL_SalesforceMemberLogin') . '/Helper/';

        // define defaults
        $defaults = array(
            'client_id' => false,
            'client_secret' => false,
            'redirect_uri' => false,
            'endpoint_uri' => 'https://login.salesforce.com/',
            'auth_endpoint' => 'services/oauth2/authorize',
            'token_endpoint' => 'services/oauth2/token',
            'revoke_endpoint' => 'services/oauth2/revoke',
            'soap_username' => 'eranda@mmr.com.au',
            'soap_password' => 'hpi2010AFO',
            'soap_token' => '3nia3ytYeq3PGXH4k5GJOdf9',
        );

        // set custom options
        $this->options = array_merge($defaults, $custom_options);

        // get session data
        $this->getSessionVars();

        // load OAuth AND SF libraries
        require($this->helper_dir . 'OAuth2/Client.php');
        require($this->helper_dir . 'OAuth2/GrantType/IGrantType.php');
        require($this->helper_dir . 'OAuth2/GrantType/AuthorizationCode.php');
        require($this->helper_dir . 'soapclient/SforcePartnerClient.php');

        // initiate oauth
        if( $this->options['client_id'] !== false && $this->options['client_secret'] !== false )
        {
            $this->oauth = new OAuth2\Client($this->options['client_id'], $this->options['client_secret']);
            $this->soap = new SforcePartnerClient();
            return true;
        }
        else
        {
            return false;
        }

    }

    function getOption($option) {
        return (isset($this->options[$option])) ? $this->options[$option] : false;
    }

    function getEndpoint($endpoint) {
        return $this->getOption('endpoint_uri') . $this->getOption($endpoint . '_endpoint');
    }

    function setToken($token) {
        $this->token = $token;
        $_SESSION['nrl_sf_access_token'] = $token;
    }

    function setAuth($authenticated) {
        $this->authenticated = $authenticated;
        $_SESSION['nrl_sf_auth'] = $authenticated;
    }

    function getAuth() { return $this->authenticated; }

    function setUser($user) {
        $this->user = $user;
        $_SESSION['nrl_sf_user_identity'] = $user;
    }

    function getUser() { return $this->user; }

    function doAuth() {

/*
        if( $this->authenticated === false )
        {
*/

            if( ! isset($_GET['code']) )
            {
                // generate oauth endpoint URL
                $auth_url = $this->oauth->getAuthenticationUrl($this->getEndpoint('auth'), $this->getOption('redirect_uri'));

                // redirect user to oauth endpoint
                header('Location: ' . $auth_url); exit;
            }
            else
            {
                // request access token
                $response = $this->oauth->getAccessToken(
                    $this->getEndpoint('token'),
                    'authorization_code',
                    array(
                        'code' => $_GET['code'],
                        'redirect_uri' => $this->getOption('redirect_uri')
                    )
                );

                // return if invalid response
                if( !isset($response['result']) ) return false;

                // store response
                $this->auth_response = $response['result'];
                //print_r($this->auth_response); exit;
    
                // set access token
                $this->setToken($this->auth_response['access_token']);
    
                // retrieve user identity
                $get_user_identity = $this->apiGET( $this->auth_response['id'] );
                //print_r($get_user_identity); exit;

                // return if user identity could not be retrieved
                if( $get_user_identity === false ) return false;

                // 
                $user_identity = $this->parseUserIdentity($get_user_identity);

                //$this->setUser($user_identity);
                //print_r($user_identity); exit;
    
                // set auth status
                $this->setAuth(true);

                // retrieve user details from soap api
                $user_details = $this->getUserDetails( $user_identity['email'] );

                // set user details
                $user_details->id = $user_identity['id'];
                $user_details->email = $user_identity['email'];
                //print_r($user_details); exit;

                $this->setUser($user_details);

                //exit;
    
                return $this->authenticated;
    
            }

/*
        }
        else
        {
            return $this->authenticated;
        }
*/

    }

    function getUserDetails($email) {

        $member = false;

        define("USERNAME", $this->getOption('soap_username'));
        define("PASSWORD", $this->getOption('soap_password'));
        define("SECURITY_TOKEN", $this->getOption('soap_token'));

        $this->soap->createConnection($this->helper_dir . 'soapclient/partner.wsdl.xml');
        $this->soap->login(USERNAME, PASSWORD);

        $query = "SELECT Id, Name, Member__r.FirstName, Member__r.LastName, Member__r.Email, Status__c, ClubName__c, Address__c, Billing_Country__c, Billing_State_Province__c, Billing_Suburb_City__c, Billing_Zip_Postal_Code__c FROM Membership__c WHERE Member__r.Email = '".$email."'";
        $response = $this->soap->query($query);
    
        if( $response && count($response->records) > 0 ) :
        
    		$ids = array();
    		foreach ($response->records as $record) {
    			array_push($ids, $record->Id[0]);
    		}
    
    		// $ids is an array of record ids built in the previous step
    		$retrieve_fields = 'Id, Name, Member__r.FirstName, Member__r.LastName, Member__r.Email, Status__c, ClubName__c, Address__c, Billing_Country__c, Billing_State_Province__c, Billing_Suburb_City__c, Billing_Zip_Postal_Code__c';
    		$retrieve_object = 'Membership__c';

    		$response = $this->soap->retrieve($retrieve_fields, $retrieve_object, $ids);
    
            //print_r($response); exit;

            if( count($response) > 0 ) :
                $member = $response[0]->fields;
            endif;
    
            //print_r($member); exit;

        endif;

        return $member;

    }

    function getSessionVars() {
        if(isset($_SESSION['nrl_sf_auth'])) $this->authenticated = $_SESSION['nrl_sf_auth'];
        if(isset($_SESSION['nrl_sf_access_token'])) $this->access_token = $_SESSION['nrl_sf_access_token'];
        if(isset($_SESSION['nrl_sf_user_identity'])) $this->user = $_SESSION['nrl_sf_user_identity'];
    }

    function revokeAuth() {
        $revoke_token = $this->apiPOST( $this->getEndpoint('revoke') , array( 'token' => $this->token ), false);
        print_r($revoke_token); exit;

    }

    function apiPOST($url, $fields, $auth=true) {

        $fields_string = '';

        // prepare POST data
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if($auth)
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth '.$this->token));
        }
        
        $result = curl_exec($ch);

        return $result;

    }

    function apiGET($url, $fields=array(), $auth=true, $header=false) {

        // prepare query data & format query string
        $fields_string = '';
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');
        if( strlen($fields_string) > 0 ) $url = $url . '?' . $fields_string;

        // prepare curl request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth '.$this->token));

        // start request
        $response = curl_exec($ch);

        // return if curl failed
        //print_r(curl_errno($ch)); exit;
        if(curl_errno($ch)) return false;

        // retrieve info about the request
        $curl_info = curl_getinfo($ch); //print_r($curl_info); exit;
        $response_header = substr($response, 0, $curl_info['header_size']);
        $response_body = substr($response, $curl_info['header_size']);

        // end request
        curl_close($ch);

        // return if invalid status code received
        if( $curl_info['http_code'] != '302' && $curl_info['http_code'] != '200' ) return false;

        // if redirect required (302), re-process request with new URL
        if( $curl_info['http_code'] == '302' )
        {
            $redirect_url = $this->getRedirectURL($response_header);
            $response_body = $this->apiGET($redirect_url);
        }

        return $response_body;

    }

    function parseUserIdentity($data) {

        $user_data = json_decode($data);

        $user_identity = array(
            'id' => $user_data->user_id,
            'first_name' => $user_data->first_name,
            'last_name' => $user_data->last_name,
            'email' => $user_data->email,
            'nick_name' => $user_data->nick_name,
        );

        return $user_identity;

    }

    function getRedirectURL($header) {
        if(preg_match('/^Location:\s+(.*)$/mi', $header, $m)) return trim($m[1]);
        return "";
    }

}