<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_TDMDownloadsCats {
	public function __construct() {
	}

	public function xtw_get_tdmdownloads_cat() {
		#SELECT * FROM x58b52_tdmdownloads_cat;
		$tdmdownloads_cat_table = XTW_XPS_Modules_Check::xtw_get_xoops_tables( true ) . 'tdmdownloads_cat';

		$query = "
		SELECT
			cat_title as cat_name,
			cat_description_main as category_description,
			cat_imgurl as _cat_thumbnail,
			cat_cid as _tdmcat_old_id
		FROM $tdmdownloads_cat_table;
		";

		return XTW_Query::xtw_make_query( $query );
	}

	public function xtw_set_tdmdownloads_cat() {
		$tdm_cats = self::xtw_get_tdmdownloads_cat();
		foreach ( $tdm_cats as $cat => $key ):
			$category_image = XTW_XoopsUrl::xtw_xoops_home_url() . "/uploads/TDMDownloads/images/cats/$key->_cat_thumbnail";
			$image_url      = XTW_SetThumb::xtw_get_image( $category_image )['url'];
			$args           = array(
				'cat_name'             => $key->cat_name,
				'category_description' => $key->category_description,
				'taxonomy'             => 'downloads_tax'
			);

			$cat_id = wp_insert_category( $args );

			add_term_meta( $cat_id, '_tdmcat_old_id', $key->_tdmcat_old_id );
			add_term_meta( $cat_id, '_cat_thumbnail', $image_url );
		endforeach;
	}
}