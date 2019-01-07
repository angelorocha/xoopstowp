<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_WFLinks{

	public function __construct() {

	}

	public function xtw_get_wflinks_items() {
		$wflinks_table = XTW_XPS_Modules_Check::xtw_get_xoops_tables( true ) . 'wflinks_links';
		$query         = "
			SELECT
				title as post_title,
				description as post_content,
				submitter as post_author,
				from_unixtime(`date`, '%Y-%m-%d %H:%i:%s') as post_date,
				from_unixtime(published, '%Y-%m-%d %H:%i:%s') as post_date_gmt,
				url as _wfl_link,
				country as _wfl_country,
				street1 as _wfl_address,
				town as _wfl_city,
				zip as _wfl_zipcode,
				state as _wfl_state,
				tel as _wfl_phone,
				fax as _wfl_fax,
				mobile as _wfl_mobile,
				email as _wfl_mail,
				hits as post_views,
				lid as _wfl_old_id,
				cid as _wflcat_old_id
			FROM $wflinks_table WHERE status <> 0;
		";

		return XTW_Query::xtw_make_query( $query );
	}

	public function xtw_set_wflinks_items() {

		$wflinks_items = self::xtw_get_wflinks_items();

		foreach ( $wflinks_items as $wflinks_item => $key ):

			$check_post = XTW_Query::xtw_get_old_id( 0, $key->_wfl_old_id, '_wfl_old_id' );

			$content = "$key->post_content";
			$content .= "";

			$args = array(
				'post_author'  => XTW_Query::xtw_get_old_id( 1, $key->post_author ),
				'post_title'   => $key->post_title,
				'post_date'    => $key->post_date,
				'post_content' => XTW_BBcode::bbcode_to_html_parser( $content ),
				'post_status'  => 'publish',
				'post_type'    => 'wflinks',
				'meta_input'   => array(
					'_wfl_country' => $key->_wfl_country,
					'_wfl_address' => $key->_wfl_address,
					'_wfl_city'    => $key->_wfl_city,
					'_wfl_zipcode' => $key->_wfl_zipcode,
					'_wfl_state'   => $key->_wfl_state,
					'_wfl_phone'   => $key->_wfl_phone,
					'_wfl_fax'     => $key->_wfl_fax,
					'_wfl_mobile'  => $key->_wfl_mobile,
					'_wfl_mail'    => $key->_wfl_mail,
					'post_views'   => $key->post_views,
					'_wfl_old_id'  => $key->_wfl_old_id
				),
				'tax_input'    => array(
					'wflinks_tax' => XTW_Query::xtw_get_old_id( 2, $key->_wflcat_old_id, '_wflcat_old_id' ),
				)
			);

			if ( ! $check_post ):
				wp_insert_post( $args );
			endif;

		endforeach;
	}
}