<?php
// return the base path of our server
define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/ecommerce/');
define('CART_COOKIE','SBhhfjjJSJjsjdjSD');
define('CART_COOKIE_EXPIRE',time() + (86400 * 30));
define('TAXRATE',0); //SALES TAX RATE 0.01 or -0.01 (+10% or -10%)

define('CURRENCY', 'ngn'); //CURENCY
define('CHECKOUTMODE', 'TEST'); // change TEST to LIVE when you are ready to go LIVE
define('TIMEZONE','Africa/Lagos');
<<<<<<< HEAD
define('CART_WISH_RATING',4);
define('PURCHASE_RATING',5);
=======
>>>>>>> 00946282fd0ced214a37681e144e38779b687dd4

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
