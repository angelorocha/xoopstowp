<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_Forum {

	public function __construct() {
	}

	/***
	 * @return array|null|object
	 * Insert bbPress Forums
	 */
	public function xtw_get_forums() {

		$forum_table = XTW_XPS_Modules_Check::xtw_get_xoops_tables( true ) . 'bb_forums';

		$query = "
		SELECT
			 CONCAT(1) as post_author,
			 forum_name as post_title,
			 forum_desc as post_content,
			 CONCAT('publish') as post_status,
			 CONCAT('forum') as post_type,
			 forum_order as menu_order,
			 forum_topics as _bbp_topic_count,
			 forum_topics as _bbp_total_topic_count,
			 forum_posts as _bbp_reply_count,
			 forum_posts as _bbp_total_reply_count,
			 forum_last_post_id as _bbp_last_topic_id,
			 forum_id as _forum_old_id
		FROM $forum_table;
		";

		return XTW_Query::xtw_make_query( $query );
	}

	public function xtw_set_forums() {

		foreach ( self::xtw_get_forums() as $key => $forum ):
			$check_post = XTW_Query::xtw_get_old_id( 0, $forum->_forum_old_id, '_forum_old_id' );
			$post       = array(
				'post_author'  => XTW_Query::xtw_get_old_id( 1, $forum->post_author ),
				'post_title'   => $forum->post_title,
				'post_date'    => $forum->post_date,
				'post_content' => XTW_BBcode::bbcode_to_html_parser( $forum->post_content ),
				'post_status'  => 'publish',
				'post_type'    => 'forum',
				'menu_order'   => $forum->menu_order
			);
			$meta       = array(
				'_forum_old_id'             => $forum->_forum_old_id,
				'_bbp_forum_id'             => '',
				'_bbp_forum_subforum_count' => '0',
				'_bbp_reply_count'          => $forum->_bbp_reply_count,
				'_bbp_topic_count'          => $forum->_bbp_topic_count,
				'_bbp_topic_count_hidden'   => '0',
				'_bbp_total_reply_count'    => $forum->_bbp_reply_count,
				'_bbp_total_topic_count'    => $forum->_bbp_topic_count,
			);
			if ( ! $check_post ):
				$post_id = wp_insert_post( $post );
				foreach ( $meta as $k => $value ):
					add_post_meta( $post_id, $k, $k === '_bbp_forum_id' ? $post_id : $value );
				endforeach;
			endif;
		endforeach;
	}

	/***
	 * @return array|null|object
	 * Insert bbPress Topics
	 */
	public function xtw_get_topics() {

		$prefix = XTW_XPS_Modules_Check::xtw_get_xoops_tables( true );
		$topics = $prefix . 'bb_topics';
		$posts  = $prefix . 'bb_posts';
		$text   = $prefix . 'bb_posts_text';

		$query = "
		SELECT
			posts.post_id,
			topics.topic_id as _topic_old_id,
			topics.topic_title,
			posts.subject as post_title,
			ptext.post_text as post_content,
			topics.topic_poster as post_author,
			from_unixtime(topics.topic_time, '%Y-%m-%d %H:%i:%s') as post_date,
			topics.topic_views as post_views,
			topics.topic_replies as _bbp_reply_count,
			topics.topic_last_post_id,
			topics.forum_id as _forum_old_id,
			topics.approved
		FROM $topics as topics
		INNER JOIN
		$posts as posts ON posts.topic_id = topics.topic_id
		INNER JOIN
		$text as ptext ON ptext.post_id = posts.post_id 
		WHERE topics.approved != '-1' 
		AND
		posts.pid = 0;
		";

		return XTW_Query::xtw_make_query( $query );
	}

	public function xtw_set_topics() {
		foreach ( self::xtw_get_topics() as $key => $topic ):
			$check_post  = XTW_Query::xtw_get_old_id( 0, $topic->_topic_old_id, '_topic_old_id' );
			$post_author = XTW_Query::xtw_get_old_id( 1, $topic->post_author );
			$post        = array(
				"post_author"  => ( ! empty( $post_author ) ? $post_author : "1" ),
				"post_title"   => $topic->post_title,
				"post_date"    => $topic->post_date,
				"post_content" => XTW_BBcode::bbcode_to_html_parser( $topic->post_content ),
				"post_status"  => "publish",
				"post_type"    => "topic",
				"post_parent"  => XTW_Query::xtw_get_old_id( 0, $topic->_forum_old_id, '_forum_old_id' )
			);

			$meta = array(
				"post_views"       => $topic->post_views,
				"_topic_old_id"    => $topic->_topic_old_id,
				"_bbp_forum_id"    => XTW_Query::xtw_get_old_id( 0, $topic->_forum_old_id, '_forum_old_id' ),
				"_bbp_reply_count" => $topic->_bbp_reply_count,
				"_bbp_topic_id"    => ""
			);

			if ( ! $check_post ):
				$post_id = wp_insert_post( $post );
				foreach ( $meta as $k => $value ):
					add_post_meta( $post_id, $k, $k === '_bbp_topic_id' ? $post_id : $value );
				endforeach;
			endif;

		endforeach;
	}

	/***
	 * @return array|null|object
	 * Insert bbPress Replies
	 */
	public function xtw_get_replies() {

		$prefix = XTW_XPS_Modules_Check::xtw_get_xoops_tables( true );
		$topics = $prefix . 'bb_topics';
		$posts  = $prefix . 'bb_posts';
		$text   = $prefix . 'bb_posts_text';

		$query = "
			SELECT
				posts.post_id as _reply_old_id,
				topics.topic_id as _topic_old_id,
				topics.topic_title,
				posts.subject as post_title,
				ptext.post_text as post_content,
				posts.uid as post_author,
				from_unixtime(posts.post_time, '%Y-%m-%d %H:%i:%s') as post_date,
				topics.forum_id as _forum_old_id,
				topics.approved
			FROM $topics as topics
			INNER JOIN
			$posts as posts ON posts.topic_id = topics.topic_id
			INNER JOIN
			$text as ptext ON ptext.post_id = posts.post_id 
			WHERE topics.approved != '-1' 
			AND
			posts.pid != 0;
		";

		return XTW_Query::xtw_make_query( $query );
	}

	public function xtw_set_replies() {
		foreach ( self::xtw_get_replies() as $key => $reply ):

			$check_post  = XTW_Query::xtw_get_old_id( 0, $reply->_reply_old_id, '_reply_old_id' );
			$post_author = XTW_Query::xtw_get_old_id( 1, $reply->post_author );

			$post = array(
				'post_author'  => ( ! empty( $post_author ) ? $post_author : "1" ),
				'post_title'   => $reply->post_title,
				'post_content' => XTW_BBcode::bbcode_to_html_parser( $reply->post_content ),
				'post_date'    => $reply->post_date,
				'post_status'  => 'publish',
				'post_type'    => 'reply',
				'post_parent'  => XTW_Query::xtw_get_old_id( 0, $reply->_topic_old_id, '_topic_old_id' ),
				'menu_order'   => $key,
			);
			$meta = array(
				"_reply_old_id" => $reply->_reply_old_id,
				"_topic_old_id" => $reply->_topic_old_id,
				"_forum_old_id" => $reply->_forum_old_id,
				"_bbp_forum_id" => XTW_Query::xtw_get_old_id( 0, $reply->_forum_old_id, '_forum_old_id' ),
				"_bbp_topic_id" => XTW_Query::xtw_get_old_id( 0, $reply->_topic_old_id, '_topic_old_id' )
			);

			if ( ! $check_post ):
				$post_id = wp_insert_post( $post );
				foreach ( $meta as $k => $value ):
					add_post_meta( $post_id, $k, $value );
				endforeach;
			endif;

		endforeach;
	}
}