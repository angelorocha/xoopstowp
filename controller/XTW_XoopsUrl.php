<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_XoopsUrl {

	public function __construct() {

	}

	public static function xtw_xoops_home_url() {
		$xoops_conf_table = XTW_XPS_Modules_Check::xtw_get_xoops_tables( true ) . 'config';
		$query            = "SELECT conf_value FROM $xoops_conf_table WHERE conf_name LIKE \"xoops_url\";";

		return XTW_Query::xtw_make_query( $query )[0]->conf_value;
	}
}