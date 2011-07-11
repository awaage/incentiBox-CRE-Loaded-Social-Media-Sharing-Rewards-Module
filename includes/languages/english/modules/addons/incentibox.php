<?php
/*
  $Id: includes/languages/english/modules/addons/incentibox.php,v 1.0.0 20110710 awaage Exp $

  CRE Loaded, Open Source E-Commerce Solutions
  http://www.creloaded.com

  Copyright (c) 2008 CRE Loaded
  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
  define('MODULE_ADDONS_INCENTIBOX_TITLE', 'incentiBox Social Media Sharing Rewards');

 if (strpos(STORE_OWNER_EMAIL_ADDRESS, '<')) {
    $store_email = substr(strstr(htmlentities(STORE_OWNER_EMAIL_ADDRESS), htmlentities('<')), 4, -4);
  } else {
    $store_email = STORE_OWNER_EMAIL_ADDRESS;
  }
  $http_server = (defined('HTTP_CATALOG_SERVER')) ? HTTP_CATALOG_SERVER : '';

  define('MODULE_ADDONS_INCENTIBOX_DESCRIPTION', '<p>'. tep_image(DIR_WS_IMAGES . 'incentiBox_logo.png', 'incentiBox', '190','75','style="display:block;margin:0px auto;"') .'<br />The incentiBox Social Media Sharing Rewards module enables users to sign in to your CREloaded store via Facebook account, and incentivizes your customers and site-visitors to "like" your Facebook page, and share your products with their friends via social media (Facebook, Twitter, Tumblr, and 300+ others). In return, your customers will receive store credit, redeemable only at your store! <br/><br /><strong>Special offer for CRE Loaded Merchants: <a target="_blank" href="http://www.incentibox.com/sign_up?referral=cre1&store_owner=' . STORE_OWNER . '&store_email=' . $store_email . '&store_url=' . $http_server . DIR_WS_CATALOG . '&store_name=' . STORE_NAME . '">Sign up today</a> for TWO months free service!</strong> <br />Please see <a target="_blank" href="http://www.incentibox.com/sign_up?referral=cre1&store_owner=' . STORE_OWNER . '&store_email=' . $store_email . '&store_url=' . $http_server . DIR_WS_CATALOG . '&store_name=' . STORE_NAME . '">incentiBox</a> for more details and to create your account.</p>');
?>