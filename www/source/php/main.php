<?php
//Get language
if(isset($_GET['locale'])) {
  $lang = $_GET['locale'];
  setcookie("lang",$lang);
  unset($_GET['locale']);
} elseif(isset($_COOKIE['lang']) && isset($_GET['locale'])) {
  $_COOKIE['lang'] = $_GET['locale'];
  unset($_GET['locale']);
} elseif(isset($_COOKIE['lang'])) {
  $lang = $_COOKIE['lang'];
  unset($_GET['locale']);
} else {
  $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
  setcookie("lang",$lang);
  unset($_GET['locale']);
}

switch ($lang){
  case "de":
    include($_SERVER['DOCUMENT_ROOT']."/source/lang/de.php");
    break; 
  // case "en":
  //   include($_SERVER['DOCUMENT_ROOT']."/source/lang/en.php");
  //   break;   
  default:
    include($_SERVER['DOCUMENT_ROOT']."/source/lang/de.php");
    break;
}

//Setup
if(!isset($_SESSION['u'])) {
  session_start();
}

//Imports
require_once("mysql.php");
require_once("links.php");
require_once("functions.php");

//Set timezone
date_default_timezone_set('Europe/Berlin');


?>