<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

abstract class XTW_Query {

	public function __construct() {
	}

	/**
	 * @param $query
	 *
	 * @return array|null|object
	 */
	public static function xtw_make_query( $query ) {
		global $wpdb;

		return $wpdb->get_results( $query );
	}

	/**
	 * @param $table
	 * @param $meta_value
	 * @param string $meta_key
	 *
	 * @return array|string
	 */
	public static function xtw_get_old_id( $table, $meta_value, $meta_key = '_old_id' ) {
		global $wpdb;

		$data = '';
		$col  = '';

		if ( $table == 0 ):
			$data = $wpdb->postmeta;
			$col  = 'post_id';
		endif;

		if ( $table == 1 ):
			$data = $wpdb->usermeta;
			$col  = 'user_id';
		endif;

		if ( $table == 2 ):
			$data = $wpdb->termmeta;
			$col  = 'term_id';
		endif;

		if ( empty( $table ) || $table > 2 ):
			false;
		endif;

		$query = "SELECT $col FROM $data WHERE meta_key LIKE '$meta_key' AND meta_value LIKE '$meta_value' LIMIT 1;";

		$result = $wpdb->get_results( $query );

		$old_id = array();

		foreach ( $result as $id ):
			$old_id[] = $id->$col;
		endforeach;

		return ( $col == 'term_id' ? $old_id : implode( $old_id ) );
	}

	/**
	 * @param $object
	 *
	 * @return int
	 */
	public static function xtw_count_table_rows( $object ) {
		return count( $object );
	}
}