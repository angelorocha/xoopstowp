<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_PartnersCat {

	public function __construct() {
	}

	public function xtw_get_partners_cat() {

		$xoopspartnes_cat_table = XTW_XPS_Modules_Check::xtw_get_xoops_tables( true ) . 'partners_category';

		$query = "
		SELECT
			cat_title as cat_name,
			cat_description as category_description,
			cat_id as _xpcat_old_id
		FROM $xoopspartnes_cat_table;
		";

		return XTW_Query::xtw_make_query( $query );
	}

	public function xtw_set_partners_cat() {

		$partners_cat = self::xtw_get_partners_cat();

		foreach ( $partners_cat as $cat => $key ):
			$args   = array(
				'cat_name'             => $key->cat_name,
				'category_description' => $key->category_description,
				'taxonomy'             => 'parceiros_tax'
			);
			$cat_id = wp_insert_category( $args );
			add_term_meta( $cat_id, '_xpcat_old_id', $key->_xpcat_old_id );
		endforeach;
	}

}