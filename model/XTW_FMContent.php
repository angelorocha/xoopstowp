<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_FMContent {
	public function __construct() {
	}

	public function xtw_get_fmcontent() {

		$fmcontent_table = XTW_XPS_Modules_Check::xtw_get_xoops_tables( true ) . 'fmcontent_content';

		$query = "
		SELECT
			content_title as post_title,
			CONCAT (content_short, \"\n\n\", content_text) as post_content,
			from_unixtime(content_create, \"%Y-%m-%d %H:%i:%s\") as post_date,
			from_unixtime(content_update, \"%Y-%m-%d %H:%i:%s\") as post_modified,
			content_uid as post_author,
			content_order as menu_order,
			content_hits as post_views,
			content_id as _fm_old_id
		FROM $fmcontent_table;
		";

		return XTW_Query::xtw_make_query( $query );
	}

	public function xtw_set_fmcontent() {

		$pages = self::xtw_get_fmcontent();

		foreach ( $pages as $page => $key):
			$check_post = XTW_Query::xtw_get_old_id( 0, $key->_fm_old_id, '_fm_old_id' );
			$args       = array(
				'post_author'  => XTW_Query::xtw_get_old_id( 1, $key->post_author ),
				'post_title'   => $key->post_title,
				'post_date'    => $key->post_date,
				'post_content' => XTW_BBcode::bbcode_to_html_parser( $key->post_content ),
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'meta_input'   => array(
					'post_views'        => $key->post_views,
					'_fm_old_id' => $key->_fm_old_id
				)
			);
			if ( ! $check_post ) {
				wp_insert_post( $args );
			}
		endforeach;
	}
}