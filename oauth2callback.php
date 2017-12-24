<?php
require_once __DIR__.'/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfigFile('client_secret.json');
// $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/lbkcbc/oauth2callback.php');
// $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php'); // v.1.1.94 host > http://www.lbkcbc.org
$client->setRedirectUri('https://lbk7.herokuapp.com/oauth2callback.php'); // use heroku server
$client->setAccessType("offline");                          // offline access
$client->setIncludeGrantedScopes(true);                     // incremental auth
$client->addScope(Google_Service_Calendar::CALENDAR);

if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  // $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/lbkcbc/work_calendar_manage.php';
  // $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/work_calendar_manage.php'; // v.1.1.94 host > http://www.lbkcbc.org
  $redirect_uri = 'http://localhost/lbkcbc/work_calendar_manage.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

?>