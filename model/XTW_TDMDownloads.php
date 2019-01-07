<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_TDMDownloads {
	public function __construct() {

	}

	public function xtw_get_tdmdownloads() {

		$tdmdownloads_table = XTW_XPS_Modules_Check::xtw_get_xoops_tables( true ) . 'tdmdownloads_downloads';

		$query = "
		SELECT 
			title as post_title,
			description as post_content,
			submitter as post_author,
			from_unixtime(`date`, '%Y-%m-%d %H:%i:%s') as post_date,
			url as _tdm_down_url,
			homepage as _tdm_down_site,
			`version` as _tdm_down_version,
			`size` as _tdm_down_size,
			lid as _tdm_old_id,
			cid as _tdmcat_old_id,
			hits as post_views
		FROM $tdmdownloads_table;
		";

		return XTW_Query::xtw_make_query( $query );
	}

	public function xtw_set_tdmdownloads() {

		$downloads = self::xtw_get_tdmdownloads();

		foreach ( $downloads as $download => $key ):

			$check_post = XTW_Query::xtw_get_old_id( 0, $key->_tdm_old_id, '_tdm_old_id' );

			$content = "$key->post_content \n\n";
			$content .= __( 'Download Link:', 'xtw' ) . " <a href='$key->_tdm_down_url' title='Download' target='_blank'>Download</a> \n";
			$content .= __( 'Download Site:', 'xtw' ) . " <a href='$key->_tdm_down_site' title='Site' target='_blank'>$key->_tdm_down_site</a> \n";
			$content .= __( 'Version:', 'xtw' ) . " " . ( ! empty( $key->_tdm_down_version ) ? $key->_tdm_down_version : "----" ) . "\n";
			$content .= __( 'Size:', 'xtw' ) . " " . $key->_tdm_down_size . " bytes \n";

			$args = array(
				'post_author'  => XTW_Query::xtw_get_old_id( 1, $key->post_author ),
				'post_title'   => $key->post_title,
				'post_date'    => $key->post_date,
				'post_content' => XTW_BBcode::bbcode_to_html_parser( $content ),
				'post_status'  => 'publish',
				'post_type'    => 'downloads',
				'meta_input'   => array(
					'post_views'        => $key->post_views,
					'_tdm_down_url'     => $key->_tdm_down_url,
					'_tdm_down_site'    => $key->_tdm_down_site,
					'_tdm_down_version' => $key->_tdm_down_version,
					'_tdm_down_size'    => $key->_tdm_down_size,
					'_tdm_old_id'       => $key->_tdm_old_id
				),
				'tax_input'    => array(
					'downloads_tax' => XTW_Query::xtw_get_old_id( 2, $key->_tdmcat_old_id, '_tdmcat_old_id' ),
				)
			);

			if ( ! $check_post ):
				wp_insert_post( $args );
			endif;

		endforeach;
	}
}