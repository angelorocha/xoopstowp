<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_Publisher {

	public function __construct() {
	}

	public function xtw_get_publisher_itens() {

		$publisher_table = XTW_XPS_Modules_Check::xtw_get_xoops_tables( true ) . 'publisher_items';

		$query = "
		SELECT 
			uid as post_author,
			title as post_title,
			CONCAT(summary, \"\n\n\", body) as post_content,
			from_unixtime(datesub, '%Y-%m-%d %H:%i:%s') as post_date,
			counter as post_views,
			categoryid as post_terms,
			itemid as _publisher_old_id
		FROM $publisher_table;
		";

		return XTW_Query::xtw_make_query( $query );
	}

	public function xtw_set_publisher_itens() {
		$articles = self::xtw_get_publisher_itens();
		foreach ( $articles as $entry => $key ):
			$check_post = XTW_Query::xtw_get_old_id( 0, $key->_publisher_old_id, '_publisher_old_id' );
			$args       = array(
				'post_author'  => XTW_Query::xtw_get_old_id( 1, $key->post_author ),
				'post_title'   => $key->post_title,
				'post_date'    => $key->post_date,
				'post_content' => XTW_BBcode::bbcode_to_html_parser( $key->post_content ),
				'post_status'  => 'publish',
				'post_type'    => 'article',
				'tax_input'    => array(
					'category_article' => XTW_Query::xtw_get_old_id( 2, $key->post_terms, '_publisher_cat_old_id' ),
				),
				'meta_input'   => array(
					'post_views'        => $key->post_views,
					'_publisher_old_id' => $key->_publisher_old_id
				)
			);
			if ( ! $check_post ) {
				wp_insert_post( $args );
			}
		endforeach;
	}
}