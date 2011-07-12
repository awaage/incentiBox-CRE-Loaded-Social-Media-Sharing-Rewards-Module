<?php
/*
  $Id: admin/incentibox_listener.php,v 1.0.0.0 2011/07/10 awaage Exp $

  CRE Loaded, Open Source E-Commerce Solutions
  http://www.creloaded.com

  Copyright (c) 2007 CRE Loaded
  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

*/
$VERBOSE = false;

// Check that either we are running via command line or that ib_run param exists 
if (empty($_GET["ib_run"])){
	header("HTTP/1.0 500 Internal Server Error");
	header("incentiBoxSuccess: FALSE");
	exit();
}
require('../includes/application_top.php');
require_once(DIR_WS_CLASSES . 'incentibox_api.php');
	
/* Here's the plan:
 * 1. Query redeemed_rewards table for last id
 * 2. Query Incentibox API for new coupons
 * 3. Update incentibox_coupons table with new entries
 * 4. Create coupons for those new entries
*/

// 1. Query redeemed_rewards table for last id
$last_coupon_id = find_last_coupon_id();
if ($VERBOSE) echo "Last coupon id in incentibox_coupons is [" . $last_coupon_id . "]. \n";


// 2. Query Incentibox API for new redeemed_rewards
if ($VERBOSE) echo "Connecting to IncentiBox API. \n";
$incentibox_client = new IncentiboxApi(INCENTIBOX_API_USER, INCENTIBOX_API_PASSWORD);
// returns all the redeemed_rewards for this program 
$new_rewards_array = $incentibox_client->get_redeemed_rewards(INCENTIBOX_PROGRAM_ID, $last_coupon_id);
if ($VERBOSE) echo "Found [" . count($new_rewards_array) . "] new entries. \n";

// 3. Update redeemed_rewards table with new entries
update_incentibox_coupons($new_rewards_array);
if ($VERBOSE) echo "Updated incentibox_coupons with [" . count($new_rewards_array) . "] new entries. \n";


// 4. Create coupons for those new entries
$created_coupons_count = create_new_coupons();
if ($VERBOSE) echo "Successfully created [". $created_coupons_count ."] coupons! \n";
if ($VERBOSE) echo "Done \n";


header("HTTP/1.0 200 OK");
header("incentiBoxSuccess: TRUE");
exit;



// Based on incentibox_coupons table, creates any new coupons
// Returns the # of new coupons created
function create_new_coupons(){
	// TABLE_COUPONS fields
	$coupon_type = 'F'; 	// Flat discount - changed from "G" for gift voucher
	$uses_per_coupon = 1; 	// default 1
	$uses_per_user = 1; 	// default 0
	$coupon_active = 'Y'; 	// default 'Y'
	$coupon_expires_in_days = INCENTIBOX_COUPON_EXPIRES_DAYS;
	// TABLE_COUPON_EMAIL_TRACK fields
	$sender_firstname = 'IncentiBox Rewards'; 
	$sender_id = 0;      	// Can be replaced by actual admin id; for now, use 0

	$select_new_coupons_query = tep_db_query("SELECT ic.* FROM incentibox_coupons ic LEFT JOIN " . TABLE_COUPONS . " tc ON ic.coupon_code = tc.coupon_code WHERE tc.coupon_code IS NULL");

	$coupon_counter = 0;
	while($coupon = tep_db_fetch_array($select_new_coupons_query)) {
		$insert_coupon_query = sprintf("INSERT INTO " . TABLE_COUPONS . " (coupon_code, coupon_type, coupon_amount, coupon_minimum_order, coupon_start_date, coupon_expire_date, uses_per_coupon, uses_per_user, coupon_active, date_created) VALUES ('%s', '%s', '%s', '%s', now(), DATE_ADD(now(),INTERVAL %s DAY), '%s', '%s', '%s', now())",
			$coupon['coupon_code'],
			$coupon_type,
			$coupon['coupon_amount'],
			$coupon['order_minimum'],
			$coupon_expires_in_days,
			$uses_per_coupon,
			$uses_per_user,
			$coupon_active
			);
		$insert_coupon_result = tep_db_query($insert_coupon_query);
		$insert_coupon_id = tep_db_insert_id();

		$insert_emaiL_track_query = sprintf("INSERT INTO " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('%s', '%s', '%s', '%s', now())",
			$insert_coupon_id,
			$sender_id,
			$sender_firstname,
			$coupon['emailed_to']);
		$insert_email_result = tep_db_query($insert_emaiL_track_query);
		$coupon_counter += 1;
	}
	return $coupon_counter;
}


// Adds each new coupon to the incentibox_coupons table
function update_incentibox_coupons($new_rewards_array){
	foreach($new_rewards_array as $c_idx => $coupon){
		$insert_query = sprintf("INSERT INTO incentibox_coupons (incentibox_coupon_id, coupon_code, coupon_amount, order_minimum, date_redeemed, emailed_to, date_created) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', now())", 
			mysql_real_escape_string($coupon['id']),
			mysql_real_escape_string($coupon['code']),
			mysql_real_escape_string($coupon['amount']),
			mysql_real_escape_string($coupon['order_minimum']),
			date('Y-m-d H:i:s', strtotime($coupon['redeemed_at'])),
			mysql_real_escape_string($coupon['email'])
			);
		tep_db_query($insert_query);	
	}
}

// Finds the last incentibox_coupon_id to query the incentiBox API for new coupons
function find_last_coupon_id(){
	$coupon_id_query = tep_db_query ("select incentibox_coupon_id from incentibox_coupons order by incentibox_coupon_id DESC LIMIT 1");
	$last_coupon = tep_db_fetch_array($coupon_id_query);
	return $last_coupon['incentibox_coupon_id'];
}


?>