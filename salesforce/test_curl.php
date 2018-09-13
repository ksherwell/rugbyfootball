<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    function doCurl($url) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth 00DN000000035QI!AQMAQDtQavQ.6vb7diPwUyLcJ8O.NU2uFW5wVHXchdQMBVr5Oie2fXjsadz80fCRIktyYh8XJC07ga2JyxqfdS8Q7_P1HRbj'));

        $result = curl_exec($ch);
        //print_r($result); exit;

        $response = curl_getinfo($ch);
        //print_r($response); exit;

        curl_close($ch);

        $redirect_url = get_redirect_url($result);
        //echo $redirect_url; exit;

        if( $response['http_code'] == '302' )
        {
            doCurl($redirect_url);
        }
        else
        {
            echo "Follow redirect:\n\n";
            print_r($result);
        }

        //print_r(curl_getinfo($ch));
        
    }

    doCurl('https://test.salesforce.com/id/00DN000000035QIMAY/005N0000000n57fIAA');
    
    function get_redirect_url($header) {
        if(preg_match('/^Location:\s+(.*)$/mi', $header, $m)) {
            return trim($m[1]);
        }
        return "";
    }
        
    exit;