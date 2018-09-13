<?php

class NRL_Salesforce_Member_Authentication {

    // define vars
    var $oauth = false;
    var $options = false;

    // auth vars
    var $token = false;
    var $auth_response = false;
    var $authenticated = false;
    var $user = false;
    

    function __construct($custom_options) {

        // define defaults
        $defaults = array(
            'client_id' => false,
            'client_secret' => false,
            'redirect_uri' => false,
            'endpoint_uri' => 'https://login.salesforce.com/',
            'auth_endpoint' => 'services/oauth2/authorize',
            'token_endpoint' => 'services/oauth2/token',
            'revoke_endpoint' => 'services/oauth2/revoke',
        );

        // set custom options
        $this->options = array_merge($defaults, $custom_options);

        // get session data
        $this->getSessionVars();

        // load OAuth library
        require('OAuth2/Client.php');
        require('OAuth2/GrantType/IGrantType.php');
        require('OAuth2/GrantType/AuthorizationCode.php');

        // initiate oauth
        if( $this->options['client_id'] !== false && $this->options['client_secret'] !== false )
        {
            $this->oauth = new OAuth2\Client($this->options['client_id'], $this->options['client_secret']);
        }
        else
        {
            die('CLIENT ID and/or CLIENT SECRET not set.');
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

    function getToken() { return $this->token; }

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

        if( $this->authenticated === false )
        {

            if( ! isset($_GET['code']) )
            {
                $auth_url = $this->oauth->getAuthenticationUrl($this->getEndpoint('auth'), $this->getOption('redirect_uri'));
                //echo $auth_url; exit;
                header('Location: ' . $auth_url);
                exit;
            }
            else
            {
                // do token request
                $response = $this->oauth->getAccessToken(
                    $this->getEndpoint('token'),
                    'authorization_code',
                    array(
                        'code' => $_GET['code'],
                        'redirect_uri' => $this->getOption('redirect_uri')
                    )
                );
    
                // store response
                $this->auth_response = (isset($response['result'])) ? $response['result'] : false;
                //print_r($this->auth_response); exit;
    
                // set access token
                $this->setToken($this->auth_response['access_token']);
    
                // get user identity
                $user_identity = $this->parseUserIdentity($this->apiGET($this->auth_response['id']));
                $this->setUser($user_identity);
    
                // set auth status
                $this->setAuth(true);
    
                return $this->authenticated;
    
            }

        }
        else
        {
            return $this->authenticated;
        }

    }

    function getSessionVars() {

        if(isset($_SESSION['nrl_sf_auth'])) $this->authenticated = $_SESSION['nrl_sf_auth'];
        if(isset($_SESSION['nrl_sf_access_token'])) $this->access_token = $_SESSION['nrl_sf_access_token'];
        if(isset($_SESSION['nrl_sf_user_identity'])) $this->user = $_SESSION['nrl_sf_user_identity'];

    }

    function revokeAuth() {

        $revoke_token = $this->apiPOST( $this->getEndpoint('revoke') , array( 'token' => $this->getToken() ), false);

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

        $fields_string = '';

        // prepare POST data
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        if( strlen($fields_string) > 0 )
        {
            $url = $url . '?' . $fields_string;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth '.$this->token));

        // execute curl
        $response = curl_exec($ch);
        $curl_info = curl_getinfo($ch);
        //print_r($curl_info); exit;

        $response_header = substr($response, 0, $curl_info['header_size']);
        $response_body = $body = substr($response, $curl_info['header_size']);

        curl_close($ch);

        // check for redirect
        if( $curl_info['http_code'] == '302' )
        {
            // redirect
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