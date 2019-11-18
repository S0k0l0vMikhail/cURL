<?php

require_once(); //config.php


function get_token($curl, $url, $cookie) {
        curl_setopt($curl, CURLOPT_URL, $url); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);    
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); 
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie); 
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
        $response = curl_exec($curl);
    
        if (preg_match('/<meta content="([^"]+)" name="csrf-token"/s', $response, $matches)) {
           return $matches[1];
        } 
    }

  function auth($curl, $url, $cookie, $post, $csrf_token)
  {
      $headers = array(
        'X-CSRF-Token: '.$csrf_token,
        'X-Requested-With: XMLHttpRequest'
      );
    curl_setopt($curl, CURLOPT_URL, $url); 
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); 
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36'); 
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie); 
    curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    return curl_exec($curl);
  }

  function read_brs( $curl, $url, $last_url, $cookie)
  {
    curl_setopt($curl, CURLOPT_URL, $url); 
    curl_setopt($curl, CURLOPT_REFERER, $last_url);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); 
    curl_setopt($curl, CURLOPT_POST, 0);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.0; ru; rv:1.9.1.3) Gecko/20090824 Firefox/3.5.3'); 
    curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
    curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
    return curl_exec($curl); 
   }

    function ready ($curl, $url, $last_url, $cookie){
    curl_setopt($curl, CURLOPT_URL, $url); 
    curl_setopt($curl, CURLOPT_REFERER, $last_url);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); 
    curl_setopt($curl, CURLOPT_POST, 0);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.0; ru; rv:1.9.1.3) Gecko/20090824 Firefox/3.5.3'); 
    curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
    curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
    $response = curl_exec($curl);
    if((preg_match('/<a class="btn btn-yellow js-employee-get-selfie"/s', $response)) == 1) { 
                return substr($response, 9802);
        } else {
                return false;
        }
    };

    
    for ($i = 0; $i <= 4; $i++) {
        $login = users[$i]['login'];
        $password = users[$i]['pwd'];
        $curl = curl_init();
        $cookie_file = realpath("cookie.txt");
        $url = 'https://igooods.ru/employee/sign_in';
        $newUrl = "http://igooods.ru/employee/confirm";
        $ready = "https://igooods.ru/employee/confirm?confirm=true";
        $csrf_token = get_token($curl, 'https://igooods.ru/employee/sign_in/',$cookie_file);
        $post = 'utf8=✓&authenticity_token='.$csrf_token.'&employee[login]='.$login.'&employee[password]='.$password.'';
        auth($curl, $url, $cookie_file, $post, $csrf_token);
        if (ready($curl, $ready, $newUrl, $cookie_file)){
        echo ready($curl, $ready, $newUrl, $cookie_file);
        break;
        };
    }
?>

