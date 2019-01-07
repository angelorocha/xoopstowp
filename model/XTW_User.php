<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_User {

	public function __construct() {
	}

	public function xtw_get_users() {
		$user_table = XTW_XPS_Modules_Check::xtw_get_xoops_tables( true ) . "users";
		$query      = "
		SELECT
			uname as user_login,
			`name` as display_name,
			email as user_email,
			url as user_url,
			bio as description,
			from_unixtime(user_regdate, '%Y-%m-%d %H:%i:%s') as user_registered,
			user_from,
			posts,
			pass as user_pass,
			uid as _old_id
		FROM $user_table;
		";

		return XTW_Query::xtw_make_query( $query );
	}

	public function xtw_set_users() {
		$users = self::xtw_get_users();
		foreach ( $users as $entry => $key ):
			$user_data = array(
				'user_login'      => $key->user_login,
				'user_nicename'   => $key->user_login,
				'display_name'    => $key->display_name,
				'user_email'      => $key->user_email,
				'user_url'        => $key->user_url,
				'description'     => $key->description,
				'user_registered' => $key->user_registered,
				'user_pass'       => $key->user_pass,
				'user_from'       => $key->user_from,
				'first_name'      => $key->display_name,
				'_old_id'         => $key->_old_id
			);

			$user_id = wp_insert_user( $user_data );
			add_user_meta( $user_id, 'user_from', $key->user_from );
			add_user_meta( $user_id, '_old_id', $key->_old_id );
		endforeach;
	}
}