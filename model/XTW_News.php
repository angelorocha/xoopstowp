<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_News {

	public function xtw_get_news() {

		$news_table = XTW_XPS_Modules_Check::xtw_get_xoops_tables( true ) . 'mod_news_stories';

		$query = "
		SELECT 
			uid as post_author,
			title as post_title,
			from_unixtime(published, '%Y-%m-%d %H:%i:%s') as post_date,
			CONCAT(hometext, \"\n\n\", bodytext) as post_content,
			counter as post_views,
			storyid as _old_id,
			topicid as categories,
			picture as _thumbnail
		FROM $news_table;
		";

		return XTW_Query::xtw_make_query( $query );
	}

	public function xtw_set_news() {
		$news = self::xtw_get_news();
		foreach ( $news as $new => $key ):
			$check_post = XTW_Query::xtw_get_old_id( 0, $key->_old_id );
			$old_image  = XTW_XoopsUrl::xtw_xoops_home_url() . '/uploads/news/image/' . $key->_thumbnail;
			$args       = array(
				'ID'            => $check_post ? $check_post : null,
				'post_author'   => XTW_Query::xtw_get_old_id( 1, $key->post_author ),
				'post_title'    => $key->post_title,
				'post_date'     => $key->post_date,
				'post_content'  => XTW_BBcode::bbcode_to_html_parser( $key->post_content ),
				'post_status'   => 'publish',
				'post_type'     => 'post',
				'post_category' => XTW_Query::xtw_get_old_id( 2, $key->categories ),
				'meta_input'    => array(
					'post_views' => $key->post_views,
					'_old_id'    => $key->_old_id
				)
			);

			if ( ! $check_post ):
				if ( ! empty( $key->_thumbnail ) ):
					$post_id = wp_insert_post( $args );
					XTW_SetThumb::xtw_insert_thumbnail( $old_image, $post_id );
				else:
					wp_insert_post( $args );
				endif;
			endif;

		endforeach;
	}
}