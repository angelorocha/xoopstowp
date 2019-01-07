<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_PublisherCats {

	public function __construct() {
	}

	public function xtw_publisher_get_cats() {

		$publisher_cats_table = XTW_XPS_Modules_Check::xtw_get_xoops_tables( true ) . 'publisher_categories';

		$query = "
		SELECT 
			`name` as term,
			CONCAT('category_article') as taxonomy,
			description as description,
			categoryid as _publisher_cat_old_id
		FROM $publisher_cats_table;
		";

		return XTW_Query::xtw_make_query( $query );
	}

	public function xtw_publisher_set_cats() {
		$terms = self::xtw_publisher_get_cats();
		foreach ( $terms as $term => $key ):
			$args    = array(
				'description' => $key->description,
			);
			$term_id = wp_insert_term( $key->term, $key->taxonomy, $args );
			add_term_meta( $term_id['term_id'], '_publisher_cat_old_id', $key->_publisher_cat_old_id );
		endforeach;

	}
}