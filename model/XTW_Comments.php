<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_Comments{

	public function xtw_get_comments() {
		$com_table = XTW_XPS_Modules_Check::xtw_get_xoops_tables( true ) . 'xoopscomments';
		$query     = "
		SELECT
			com_itemid AS comment_post_ID,
			from_unixtime(com_created, '%Y-%m-%d %H:%i:%s') AS comment_date,
			from_unixtime(com_modified, '%Y-%m-%d %H:%i:%s'),
			com_uid AS user_id,
			com_email AS comment_author_email,
			com_ip AS comment_author_IP,
			com_text AS comment_content
		FROM $com_table;
		";

		return XTW_Query::xtw_make_query( $query );
	}

	public function xtw_set_comments() {
		$comments = self::xtw_get_comments();

		foreach ( $comments as $key => $comment ):
			$content_ID = XTW_Query::xtw_get_old_id( 0, $comment->comment_post_ID );
			$author_ID  = ( $comment->user_id === '0' ? 2 : XTW_Query::xtw_get_old_id( 1, $comment->user_id ) );
			$args       = array(
				'user_id'              => $author_ID,
				'comment_author'       => get_userdata( $author_ID )->user_login,
				'comment_author_email' => get_userdata( $author_ID )->user_email,
				'comment_post_ID'      => $content_ID,
				'comment_content'      => XTW_BBcode::bbcode_to_html_parser( $comment->comment_content ),
				'comment_parent'       => 0,
				'comment_author_IP'    => $comment->comment_author_IP,
				'comment_date'         => $comment->comment_date,
				'comment_approved'     => 1,
			);
			if ( $content_ID ):
				wp_insert_comment( $args );
			endif;
		endforeach;
	}
}