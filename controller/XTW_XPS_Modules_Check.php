<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_XPS_Modules_Check {
	/**
	 * @param bool $get_prefix
	 *
	 * @return array|string
	 */
	public static function xtw_get_xoops_tables( $get_prefix = false ) {
		global $wpdb;
		$showtables = "Tables_in_" . DB_NAME;
		$site_db    = $wpdb->get_results( 'SHOW TABLES' );
		$prefix     = explode( '_', $wpdb->base_prefix )[0];
		$tables     = array();
		foreach ( $site_db as $key => $table ):
			$xoops_tables = explode( '_', $table->$showtables );
			if ( $xoops_tables[0] !== $prefix ):
				$tables[] = array(
					'prefix' => $xoops_tables[0],
					'table'  => implode( '_', array_splice( $xoops_tables, 1 ) )
				);
			endif;
		endforeach;
		$prefix = $tables[0]['prefix'] . '_';

		return ( $get_prefix ? $prefix : $tables );
	}

	public static function get_xoops_modules() {
		$modules = array(
			'bb_forums'              => 'NewBB',
			'mod_news_stories'       => 'News',
			'publisher_items'        => 'Publisher',
			'fmcontent_content'      => 'FMContent',
			'partners'               => 'Partners',
			'xoopstube_videos'       => 'XOOPSTube',
			'tdmdownloads_downloads' => 'TDMDownloads'
		);

		$xoops_modules = array_column( self::xtw_get_xoops_tables(), 'table' );
	}
}