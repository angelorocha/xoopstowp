<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_Partners{
	public function __construct() {
	}

	public function xtw_get_partners() {

		$xoopspartnes_table = XTW_XPS_Modules_Check::xtw_get_xoops_tables( true ) . 'partners';

		$query = "
		SELECT
			title as post_title,
			description as post_content,
			weight as menu_order,
			cat_id as _xpcat_old_id,
			hits as post_views,
			image as thumbnail,
			url as _partner_url,
			id as _partners_old_id
		FROM $xoopspartnes_table;
		";

		return XTW_Query::xtw_make_query( $query );
	}

	public function xtw_set_partners() {
		$partners = self::xtw_get_partners();

		foreach ( $partners as $partner => $key ):

			$check_post = XTW_Query::xtw_get_old_id( 0, $key->_partners_old_id, '_partners_old_id' );

			$content = $key->post_content;
			$content .= "\n\n <a href='$key->_partner_url' target='_blank'>$key->_partner_url</a> \n\n";

			$args = array(
				'post_author'  => 1,
				'post_title'   => $key->post_title,
				'post_date'    => $key->post_date,
				'post_content' => XTW_BBcode::bbcode_to_html_parser( $content ),
				'post_status'  => 'publish',
				'post_type'    => 'parceiros',
				'meta_input'   => array(
					'post_views'       => $key->post_views,
					'_partner_url'     => $key->_partner_url,
					'_partners_old_id' => $key->_partners_old_id
				),
				'tax_input'    => array(
					'parceiros_tax' => XTW_Query::xtw_get_old_id( 2, $key->_xpcat_old_id, '_xpcat_old_id' ),
				)
			);

			if ( ! $check_post ):
				$post_id = wp_insert_post( $args );
				XTW_SetThumb::xtw_insert_thumbnail( $key->thumbnail, $post_id );
			endif;

		endforeach;
	}
}