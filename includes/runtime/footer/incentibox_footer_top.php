<?php
/*
  $Id: includes/runtime/footer/incentibox_footer_top.php,v 1.0 2011/07/10 awaage Exp $

  CRE Loaded, Open Source E-Commerce Solutions
  http://www.creloaded.com

  Copyright (c) 2008 CRE Loaded
  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

*/
if (defined('MODULE_ADDONS_INCENTIBOX_STATUS') && MODULE_ADDONS_INCENTIBOX_STATUS == 'True' && INCENTIBOX_PROGRAM_ID!='') {
	$rci  = "";
	$rci .= "<script type='text/javascript'> \n";
	$rci .= " (function() { \n";
	$rci .= " var iBx = document.createElement('script'); iBx.type = 'text/javascript'; iBx.async = true; iBx.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.incentibox.com/ib.js?program_id=". INCENTIBOX_PROGRAM_ID. "'; (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(iBx); \n";
	$rci .= " })(); \n";
	$rci .= "</script> \n";
	
	$rci .= "<div class='incentibox_static' program_id='". INCENTIBOX_PROGRAM_ID. "' style='position:fixed;top:80px;right:0px'></div> \n";
	
	return $rci;
}
?>
