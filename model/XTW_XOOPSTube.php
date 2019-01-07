<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_XOOPSTube {
	public function __construct() {
	}

	public function xtw_get_xoopstube() {

		$xoopstube_table = XTW_XPS_Modules_Check::xtw_get_xoops_tables( true ) . 'xoopstube_videos';

		$query = "
		SELECT 
			title as post_title,
			CONCAT('https://www.youtube.com/watch?v=', vidid, \"\n\n\", description) as post_content,
			description	as post_excerpt,
			from_unixtime(published, \"%Y-%m-%d %H:%i:%s\") as post_date,
			submitter as post_author,
			vidid as vid_thumb,
			hits as post_views,
			lid as _xt_old_id
		FROM $xoopstube_table;
		";

		return XTW_Query::xtw_make_query( $query );
	}

	public function xtw_set_xoopstube() {
		$videos = self::xtw_get_xoopstube();
		foreach ( $videos as $video => $key ):
			$video_thumbnail = "https://img.youtube.com/vi/$key->vid_thumb/hqdefault.jpg";
			$check_post      = XTW_Query::xtw_get_old_id( 0, $key->_xt_old_id, '_xt_old_id' );
			$args            = array(
				'post_author'  => XTW_Query::xtw_get_old_id( 1, $key->post_author ),
				'post_title'   => $key->post_title,
				'post_date'    => $key->post_date,
				'post_content' => XTW_BBcode::bbcode_to_html_parser( $key->post_content ),
				'post_status'  => 'publish',
				'post_type'    => 'videos',
				'meta_input'   => array(
					'post_views' => $key->post_views,
					'_xt_old_id' => $key->_xt_old_id
				)
			);

			if ( ! $check_post ):
				$post_id = wp_insert_post( $args );
				XTW_SetThumb::xtw_insert_thumbnail( $video_thumbnail, $post_id );
			endif;

		endforeach;
	}
}