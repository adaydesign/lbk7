<?php
/*
  :: for upload document to google drive ::
  Oauth callback for heroku server
  
  Note !
  when connect with URL 10.37.84.1 use this callback
  but if connect with URL localhost use local callback
*/
require_once __DIR__.'/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfigFile('client_secret_dc.json');

$client->setRedirectUri('https://lbk7.herokuapp.com/oauth2callback_dc.php'); // use heroku server
$client->setAccessType("offline");                          // offline access
$client->setIncludeGrantedScopes(true);                     // incremental auth
$client->addScope(Google_Service_Calendar::CALENDAR);

if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  $client->authenticate($_GET['code']);
  $acc_token = serialize($client->getAccessToken());

  $redirect_uri = "http://10.37.84.1/lbkcbc/document_access.php?token=$acc_token";
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

?>