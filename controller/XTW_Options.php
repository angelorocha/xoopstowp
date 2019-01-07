<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_Options {

	/**
	 * @return string
	 */
	public static function xtw_get_memory_limit() {
		return ini_get( 'memory_limit' );
	}

	/**
	 * @return string
	 */
	public static function xtw_get_time_limit() {
		return ini_get( 'max_execution_time' );
	}

	/**
	 * @return mixed
	 */
	public static function xtw_set_time_limit() {
		return set_time_limit( 0 );
	}

	/**
	 * @return bool
	 */
	public static function xtw_check_bbpress_install() {
		$checkbbPress = is_plugin_active( 'bbpress/bbpress.php' );

		return ( $checkbbPress ? true : __( 'Please, install or activate bbPress...', 'xtw' ) );
	}
}