<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_NewsCats {

	public function __construct() {
	}

	public function xtw_get_news_topics() {

		$news_topics_table = XTW_XPS_Modules_Check::xtw_get_xoops_tables( true )."mod_news_topics";

		$query = "
		SELECT 
			topic_title as cat_name,
			topic_description as category_description,
			topic_id as _old_id
		FROM $news_topics_table;
		";

		return XTW_Query::xtw_make_query( $query );
	}

	public function xtw_set_news_topics() {
		$cats = self::xtw_get_news_topics();
		foreach ( $cats as $cat => $key ):
			$args   = array(
				'cat_name'             => $key->cat_name,
				'category_description' => $key->category_description,
				'taxonomy'             => 'category'
			);
			$cat_id = wp_insert_category( $args );
			add_term_meta( $cat_id, '_old_id', $key->_old_id );
		endforeach;
	}
}