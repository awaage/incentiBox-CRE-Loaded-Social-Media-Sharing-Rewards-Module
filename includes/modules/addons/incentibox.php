<?php
/*
	$Id: includes/modules/addons/incentibox.php, v1.0 2011/07/10 awaage Exp $

	CRE Loaded, Open Source E-Commerce Solutions
	http://www.creloaded.com

	Copyright (c) 2008 CRE Loaded
	Copyright (c) 2003 osCommerce
	Copyright (c) 2009 ContributionCentral

	Released under the GNU General Public License
*/

class incentibox {
	var $test;

	function incentibox() {
		$this->code = 'incentibox';
		$this->title = (defined('MODULE_ADDONS_INCENTIBOX_TITLE')) ? MODULE_ADDONS_INCENTIBOX_TITLE : '';
		$this->description = (defined('MODULE_ADDONS_INCENTIBOX_DESCRIPTION')) ? MODULE_ADDONS_INCENTIBOX_DESCRIPTION : '';
		if (defined('MODULE_ADDONS_INCENTIBOX_STATUS')) {
			$this->enabled = ((MODULE_ADDONS_INCENTIBOX_STATUS == 'True') ? true : false);
		} else {
			$this->enabled = false;
		}
		$this->sort_order  = (defined('MODULE_ADDONS_INCENTIBOX_SORT_ORDER')) ? (int)MODULE_ADDONS_INCENTIBOX_SORT_ORDER : 0;
	}

	function check() {
		if (!isset($this->_check)) {
			$check_query = tep_db_query("SELECT configuration_value 
				from " . TABLE_CONFIGURATION . " 
				WHERE configuration_key = 'MODULE_ADDONS_INCENTIBOX_STATUS'");
			$this->_check = tep_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function keys() {
		return array('MODULE_ADDONS_INCENTIBOX_STATUS',
			'INCENTIBOX_PROGRAM_ID',
			'INCENTIBOX_API_USER',
			'INCENTIBOX_API_PASSWORD',
			'INCENTIBOX_COUPON_ORDER_MINIMUM',
			'INCENTIBOX_COUPON_EXPIRES_DAYS'
			);
	}

	function install() {                  
		// insert module config values
		tep_db_query("INSERT IGNORE INTO `configuration` (`configuration_id`, `configuration_title`, `configuration_key`, `configuration_value`, `configuration_description`, `configuration_group_id`, `sort_order`, `last_modified`, `date_added`, `use_function`, `set_function`) VALUES ('', 'Enable incentiBox', 'MODULE_ADDONS_INCENTIBOX_STATUS', 'True', 'Enable the incentiBox Module', '811', '101', now(), now(), NULL, 'tep_cfg_select_option(array(''True'', ''False''),')");
		tep_db_query("INSERT IGNORE INTO `configuration` (`configuration_id`, `configuration_title`, `configuration_key`, `configuration_value`, `configuration_description`, `configuration_group_id`, `sort_order`, `last_modified`, `date_added`, `use_function`, `set_function`) VALUES ('', 'incentiBox Program ID', 'INCENTIBOX_PROGRAM_ID', '', 'Enter your incentiBox program_id', '811', '102', now(), now(), NULL, NULL )");
		tep_db_query("INSERT IGNORE INTO `configuration` (`configuration_id`, `configuration_title`, `configuration_key`, `configuration_value`, `configuration_description`, `configuration_group_id`, `sort_order`, `last_modified`, `date_added`, `use_function`, `set_function`) VALUES ('', 'incentiBox API User Name', 'INCENTIBOX_API_USER', '', 'Enter your incentiBox API username', '811', '103', now(), now(), NULL, NULL )");
		tep_db_query("INSERT IGNORE INTO `configuration` (`configuration_id`, `configuration_title`, `configuration_key`, `configuration_value`, `configuration_description`, `configuration_group_id`, `sort_order`, `last_modified`, `date_added`, `use_function`, `set_function`) VALUES ('', 'incentiBox API Password', 'INCENTIBOX_API_PASSWORD', '', 'Enter your incentiBox API password', '811', '104', now(), now(), NULL, NULL )");
		tep_db_query("INSERT IGNORE INTO `configuration` (`configuration_id`, `configuration_title`, `configuration_key`, `configuration_value`, `configuration_description`, `configuration_group_id`, `sort_order`, `last_modified`, `date_added`, `use_function`, `set_function`) VALUES ('', 'Coupon Order Minimum ($)', 'INCENTIBOX_COUPON_ORDER_MINIMUM', '20.00', 'Enter your minimum order amount for coupons (default 20.00)', '811', '105', now(), now(), NULL, NULL )");
		tep_db_query("INSERT IGNORE INTO `configuration` (`configuration_id`, `configuration_title`, `configuration_key`, `configuration_value`, `configuration_description`, `configuration_group_id`, `sort_order`, `last_modified`, `date_added`, `use_function`, `set_function`) VALUES ('', 'Coupon Expires in (days)', 'INCENTIBOX_COUPON_EXPIRES_DAYS', '30', 'Enter the number of days until coupons expire (default 30)', '811', '104', now(), now(), NULL, NULL )");

		// Creates incentibox_coupons table if it doesn't already exist
		$create_incentibox_table_query =<<<EOS
		CREATE TABLE IF NOT EXISTS incentibox_coupons (
			unique_id int(11) NOT NULL auto_increment,
			incentibox_coupon_id int(11) NOT NULL DEFAULT 0,
			coupon_code varchar(32) NOT NULL DEFAULT '',
			coupon_amount decimal(8,4) NOT NULL DEFAULT '0.0000',
			date_redeemed datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			emailed_to varchar(128) DEFAULT NULL,
			date_created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			PRIMARY KEY (unique_id),
			UNIQUE KEY (incentibox_coupon_id),
			UNIQUE KEY (coupon_code)
			) ENGINE=MyISAM DEFAULT COLLATE=latin1_swedish_ci AUTO_INCREMENT=1;
EOS;
		tep_db_query($create_incentibox_table_query);

		// Adds index on coupons table(coupon_code) if doesn't exist
		$find_index_query = "SHOW INDEX FROM coupons WHERE Key_name='idx_coupons_coupon_code';";
		$find_index = tep_db_query($find_index_query);
		if (tep_db_num_rows($find_index) == 0){
			$new_index_query = "CREATE INDEX idx_coupons_coupon_code ON coupons (coupon_code);";
			tep_db_query($new_index_query);		
		}

		// Alters coupon_email_track table, to extend the length of emailed_to field to 128 Chars (default 32)
		$extend_query = "ALTER TABLE coupon_email_track MODIFY emailed_to varchar (128);";
		tep_db_query($extend_query);
	}

	// Intentionally does not remove the incentibox_coupons table
	function remove() {
		tep_db_query("DELETE FROM `configuration` WHERE configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}
}  
?>