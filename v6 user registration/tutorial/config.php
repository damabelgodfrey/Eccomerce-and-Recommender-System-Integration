<?php
// return the base path of our server
define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/tutorial/');
define('CART_COOKIE','SBhhfjjJSJjsjdjSD');
define('CART_COOKIE_EXPIRE',time() + (86400 * 30));
define('TAXRATE',0); //SALES TAX RATE

define('CURRENCY', 'ngn'); //CURENCY
define('CHECKOUTMODE', 'TEST'); // change TEST to LIVE when you are ready to go LIVE

// FROM STRIPE USER ACCOUNT.
if(CHECKOUTMODE == 'TEST'){

  define('STRIPE_PRIVATE','sk_test_73lwqGriiSTqleELMKXrEmd9');
  define('STRIPE_PUBLIC','pk_test_Ii18wzg1DmS9VEj1k9bqbOoE');
}

if(CHECKOUTMODE == 'LIVE'){
  define('STRIPE_PRIVATE','sk_live_67i14XcTm54zKMvcFBpLbndy');
  define('STRIPE_PUBLIC','pk_live_nANHsDPDZNw0sjZyZ37RJCq0');
}
//echo BASEURL;
