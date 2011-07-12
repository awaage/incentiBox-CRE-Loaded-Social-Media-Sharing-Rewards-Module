<?php
/*
  $Id: admin/includes/runtime/index/incentibox_index_rightcolumn.php,v 1.0.0.0 2011/07/11 awaage Exp $

  CRE Loaded, Open Source E-Commerce Solutions
  http://www.creloaded.com

  Copyright (c) 2008 CRE Loaded
  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
if (!defined(INCENTIBOX_PROGRAM_ID) || INCENTIBOX_PROGRAM_ID=='') {
?>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 1em;">
		<tr>
			<td class="box-top-left">&nbsp;</td>
			<td class="box-top">&nbsp;</td>
			<td class="box-top-right">&nbsp;</td>              
		</tr>

		<tr>
			<td class="box-left">&nbsp;</td><td class="box-content">
				<img src="images/incentiBox_logo.png" style='width:95px; height:20px; display:block;margin:10px auto;' />
				
				<div style='width:100%; text-align:center; font-weight:bold'>Social Media Sharing Rewards Module</div> 
				<ul style='padding:0px;margin:5px 0px 0px 6px;'>
					<li>Customers sign in via Facebook account</li>
					<li>Customers are incentivized to "like" your Facebook page</li>
					<li>Customers share your products with their friends via social media (Facebook, Twitter, Tumblr, and 300+ others)</li>
					<li>In return, customers receive store credit, redeemable only at your store! </li>
				</ul>
				
				<br />
				<div style='width:100%; text-align:center; font-weight:bold'>
					<a href='/admin/modules.php?set=addons&module=incentibox'>Enable this module</a>
				</div>
				</td>
				<td class="box-right">&nbsp;</td>
		</tr>
		<tr>
			<td class="box-bottom-left">&nbsp;</td>
			<td class="box-bottom">&nbsp;</td>
			<td class="box-bottom-right">&nbsp;</td>
		</tr>
	</table>
<?php
}
?>