<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

abstract class XTW_CPTSet{

	/**
	 * @param $cpt_key
	 * @param $cpt_name
	 * @param $cpt_desc
	 * @param bool $tax_key
	 * @param bool $tax_name
	 */
	public static function xtw_cpt_add( $cpt_key, $cpt_name, $cpt_desc, $tax_key = false, $tax_name = false ) {
		$cpt = new XTW_PostTypeFactory();
		$tax = new XTW_TaxonomyFactory();

		$cpt->post_type_key  = $cpt_key;
		$cpt->post_type_name = $cpt_name;
		$cpt->post_type_desc = $cpt_desc;

		if ( $tax_key ):
			$tax->tax_key        = $tax_key;
			$tax->tax_name       = ( ! empty( $tax_name ) ? $tax_name : __( 'Categories', 'xtw' ) );
			$tax->post_type_keys = array( $cpt_key );
		endif;
	}
}