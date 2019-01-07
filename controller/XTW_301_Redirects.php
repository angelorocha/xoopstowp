<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_301_Redirects{

	public function __construct() {
		add_action( 'template_redirect', array( $this, 'xtw_newbb_home_redirect' ) );
		add_action( 'template_redirect', array( $this, 'xtw_news_redirect' ) );
		add_action( 'template_redirect', array( $this, 'xtw_publisher_redirect' ) );
		add_action( 'template_redirect', array( $this, 'xtw_fmcontent_redirect' ) );
		add_action( 'template_redirect', array( $this, 'xtw_xoopstube_redirect' ) );
		add_action( 'template_redirect', array( $this, 'xtw_partners_redirect' ) );
		add_action( 'template_redirect', array( $this, 'xtw_tdm_downloads_redirect' ) );
		add_action( 'template_redirect', array( $this, 'xtw_wf_links_redirect' ) );
		add_action( 'template_redirect', array( $this, 'xtw_users_redirect' ) );
		add_action( 'template_redirect', array( $this, 'xtw_get_url_request' ) );
	}

	public function xtw_url_redirect( $url ) {

		return wp_redirect( $url, '301' );
	}

	public function xtw_get_url() {
		return $_SERVER['REQUEST_URI'];
	}

	public function xtw_get_url_request( $get, $table, $meta ) {
		$meta_key    = ! empty( $meta ) ? "_" . $meta . "_old_id" : "_old_id";
		$meta_value  = $_GET[ $get ];
		$redirect_id = XTW_Query::xtw_get_old_id( $table, $meta_value, $meta_key );

		return $redirect_id;
	}

	public function xtw_get_permalinks( $url ) {
		return get_permalink( $url );
	}

	public function xtw_get_term_link( $url ) {
		return get_term_link( $url );
	}

	public function xtw_newbb_home_redirect() {
		if ( self::xtw_get_url() === '/modules/newbb/' ):
			$url = home_url( 'forums' );
			self::xtw_url_redirect( $url );
		endif;
		if ( isset( $_GET['forum'] ) && isset( $_GET['topic_id'] ) && isset( $_GET['post_id'] ) ):
			$topic = self::xtw_get_url_request( 'topic_id', 0, 'topic' );
			self::xtw_url_redirect( self::xtw_get_permalinks( $topic ) );
		endif;
		if ( ! isset( $_GET['forum'] ) && ! isset( $_GET['topic_id'] ) && isset( $_GET['post_id'] ) ):
			$topic    = self::xtw_get_url_request( 'post_id', 0, 'topic' );
			$reply    = self::xtw_get_url_request( 'post_id', 0, 'reply' );
			$redirect = ( ! empty( $topic ) ? $topic : get_post( $reply )->post_parent );
			self::xtw_url_redirect( self::xtw_get_permalinks( $redirect ) );
		endif;
		if ( isset( $_GET['forum'] ) && ! isset( $_GET['topic_id'] ) && ! isset( $_GET['post_id'] ) ):
			$forum = self::xtw_get_url_request( 'forum', 0, 'forum' );
			self::xtw_url_redirect( self::xtw_get_permalinks( $forum ) );
		endif;
	}

	public function xtw_news_redirect() {
		# News Topics : /modules/news/index.php?storytopic=4&storynum=15
		# News Item: /modules/news/article.php?storyid=60473
		if ( self::xtw_get_url() === '/modules/news/' ):
			$url = home_url( 'noticias' );
			self::xtw_url_redirect( $url );
		endif;
		if ( isset( $_GET['storyid'] ) ):
			$news = self::xtw_get_url_request( 'storyid', 0, '' );
			self::xtw_url_redirect( self::xtw_get_permalinks( $news ) );
		endif;
	}

	public function xtw_publisher_redirect() {
		# Publisher Archive: /modules/publisher/
		# Publisher Categories: /modules/publisher/index.php/category.1/cftv.html
		# Publisher Articles: /modules/publisher/index.php/item.98/Intelbras-MHDX.html

		$url = home_url( 'artigos' );
		if ( self::xtw_get_url() === '/modules/publisher/' ):
			self::xtw_url_redirect( $url );
		endif;
	}

	public function xtw_fmcontent_redirect() {
		# FM Content Page: /modules/fmcontent/content.php?topic=certificacao-videocad&id=11&page=certificacao-videocad-sao-paulo
		$url = home_url();
		if ( self::xtw_get_url() === '/modules/fmcontent/' ):
			self::xtw_url_redirect( $url );
		endif;
	}

	public function xtw_xoopstube_redirect() {
		# XOOPSTube Archive: /modules/xoopstube/
		# XOOPSTube Categories: /modules/xoopstube/viewcat.php?cid=2
		# XOOPSTube items: /modules/xoopstube/singlevideo.php?cid=2&lid=3

		$url = home_url( 'videos' );
		if ( self::xtw_get_url() === '/modules/xoopstube/' ):
			self::xtw_url_redirect( $url );
		endif;

		if ( isset( $_GET['lid'] ) ):
			$xoopstube = self::xtw_get_url_request( 'lid', 0, 'xt' );
			self::xtw_url_redirect( self::xtw_get_permalinks( $xoopstube ) );
		endif;
	}

	public function xtw_partners_redirect() {
		# Partners Archive: /modules/xoopspartners/
		# Partners Categories: /modules/xoopspartners/index.php?cat_id=3
		# Partners items: ---

		$url = home_url( 'parceiros' );
		if ( self::xtw_get_url() === '/modules/xoopspartners/' ):
			self::xtw_url_redirect( $url );
		endif;
	}

	public function xtw_tdm_downloads_redirect() {
		# TDM Downloads Archive: /modules/TDMDownloads/
		# TDM Downloads Categories: /modules/TDMDownloads/viewcat.php?cid=2
		# TDM Downloads items: /modules/TDMDownloads/singlefile.php?cid=2&lid=44

		$url = home_url( 'downloads' );
		if ( self::xtw_get_url() === '/modules/TDMDownloads/' ):
			self::xtw_url_redirect( $url );
		endif;

		if ( isset( $_GET['lid'] ) ):
			$downloads = self::xtw_get_url_request( 'lid', 0, 'tdm' );
			self::xtw_url_redirect( self::xtw_get_permalinks( $downloads ) );
		endif;
	}

	public function xtw_wf_links_redirect() {
		# WFLinks Archive: /modules/wflinks/
		# WFLinks Categories: /modules/wflinks/viewcat.php?cid=7
		# WFLinks Item: /modules/wflinks/visit.php?cid=1&lid=199

		$url = home_url( 'diretorio' );
		if ( self::xtw_get_url() === '/modules/wflinks/' ):
			self::xtw_url_redirect( $url );
		endif;

		if ( isset( $_GET['lid'] ) ):
			$wflinks = self::xtw_get_url_request( 'lid', 0, 'wfl' );
			self::xtw_url_redirect( self::xtw_get_permalinks( $wflinks ) );
		endif;
	}

	public function xtw_users_redirect() {
		# /modules/profile/userinfo.php?uid=60072
	}
}