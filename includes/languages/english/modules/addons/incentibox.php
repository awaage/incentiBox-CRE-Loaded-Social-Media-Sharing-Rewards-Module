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
  define('INCENTIBOX_CRELOADED_LINK', 'http://www.incentibox.com/creloaded?v=1&store_owner=' . STORE_OWNER . '&store_email=' . $store_email . '&store_url=' . $http_server . DIR_WS_CATALOG . '&store_name=' . STORE_NAME);

  define('MODULE_ADDONS_INCENTIBOX_DESCRIPTION', '<p>'. tep_image(DIR_WS_IMAGES . 'incentiBox_logo.png', 'incentiBox', '190','40','style="display:block;margin:0px auto;"') .'<br />The incentiBox Social Media Sharing Rewards module transforms ordinary customers into word-of-mouth brand advocates!<br /><br /> Incentivize customers to share your products on their social networks (Facebook wall posts, Tweets, blog posts, etc.) and to "like" your Facebook page. In return, your customers are rewarded with store credit, redeemable only at your store.<br/><br/>Incentivized sharing is a great way to generate sales and increase brand awareness for your CRE Loaded store!<br/><br /><div style="width:100%;text-align:center;font-size:13px;font-weight:bold">** Exclusive Offer **<br />CRE Loaded Merchants: </div><br /><a target="_blank" href="'. INCENTIBOX_CRELOADED_LINK .'">Sign up today</a> for TWO months free service! Please see <a target="_blank" href="'. INCENTIBOX_CRELOADED_LINK .'">incentiBox</a> for details and to create your account.</p>');
?>