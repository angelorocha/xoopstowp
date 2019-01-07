<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_WFLinksCats {

	public function __construct() {
	}

	public function xtw_get_wflinks_cats() {
		$wflinks_cat_table = XTW_XPS_Modules_Check::xtw_get_xoops_tables( true ) . 'wflinks_cat';
		$query             = "
		SELECT
			title as cat_name,
			description as category_description,
			cid as _wflcat_old_id
		FROM $wflinks_cat_table;
		";

		return XTW_Query::xtw_make_query( $query );
	}

	public function xtw_set_wflinks_cats() {
		$wflinks_cats = self::xtw_get_wflinks_cats();

		foreach ( $wflinks_cats as $wflinks_cat => $key ):
			$args = array(
				'cat_name'             => $key->cat_name,
				'category_description' => $key->category_description,
				'taxonomy'             => 'wflinks_tax'
			);
			$cat_id = wp_insert_category( $args );
			add_term_meta( $cat_id, '_wflcat_old_id', $key->_wflcat_old_id );
		endforeach;
	}
}