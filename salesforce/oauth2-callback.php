<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    session_start();

    $action = (isset($_GET['action'])) ? $_GET['action'] : 'auth';

    require('NRL_Salesforce_Member_Authentication.class.php');

    $SFAuth = new NRL_Salesforce_Member_Authentication(array(
        'client_id' => '3MVG9e2mBbZnmM6lxKNh7ziMbLby4hzbUKGdHguoO6KGOMbjWthpiPxWUOgphtNpcN9zSsuTh43J2OuvkKycM',
        'client_secret' => '8674266167508479641',
        'redirect_uri' => 'https://store.penrithpanthers.com.au/salesforce/oauth2-callback.php',
        'endpoint_uri' => 'https://nrl--ArxxusDev.cs6.my.salesforce.com/'
    ));

    if( $action == 'auth' )
    {
        $authenticated = $SFAuth->doAuth();

        if( $authenticated ) {

            print_r($SFAuth->getUser());

        }

    }

    if( $action == 'revoke' )
    {
        $SFAuth->revokeAuth();
    }

/*
require('OAuth2/Client.php');
require('OAuth2/GrantType/IGrantType.php');
require('OAuth2/GrantType/AuthorizationCode.php');

const CLIENT_ID     = '3MVG9e2mBbZnmM6lxKNh7ziMbLby4hzbUKGdHguoO6KGOMbjWthpiPxWUOgphtNpcN9zSsuTh43J2OuvkKycM';
const CLIENT_SECRET = '8674266167508479641';

const REDIRECT_URI           = 'https://store.penrithpanthers.com.au/salesforce/oauth2-callback.php';
const AUTHORIZATION_ENDPOINT = 'https://nrl--ArxxusDev.cs6.my.salesforce.com/services/oauth2/authorize';
const TOKEN_ENDPOINT         = 'https://nrl--ArxxusDev.cs6.my.salesforce.com/services/oauth2/token';

$client = new OAuth2\Client(CLIENT_ID, CLIENT_SECRET);
if (!isset($_GET['code']))
{
    $auth_url = $client->getAuthenticationUrl(AUTHORIZATION_ENDPOINT, REDIRECT_URI);
    //echo $auth_url; exit;
    header('Location: ' . $auth_url);
    die('Redirect');
}
else
{
    $params = array('code' => $_GET['code'], 'redirect_uri' => REDIRECT_URI);
    $response = $client->getAccessToken(TOKEN_ENDPOINT, 'authorization_code', $params);

    $access_token = $response['result']['access_token'];
    $client_user_url = $response['result']['id'];

    echo $access_token . '<br>';
    echo $client_user_url . '<br>';
    exit;

    //print_r($response); exit;

    $client->setAccessToken($access_token);

    $response = $client->fetch($client_user_url, array(), 'POST');

    print_r($response); exit;

    var_dump($response, $response['result']);
}

*/
