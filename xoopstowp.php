<?php
/*
Plugin Name: XOOPS to WordPress
Plugin URI: https://angelorocha.com.br
Description: Import XOOPS content to WordPress
Version: 1.0.0
Author: Angelo Rocha
Author URI: https://angelorocha.com.br
Domain Path: /lang
Text Domain: xtw
*/

require_once 'init/XTW_Import.php';

XTW_Import::xtw_autoload_plugin_files( 'controller' );
XTW_Import::xtw_autoload_plugin_files( 'controller/cpt' );
XTW_Import::xtw_autoload_plugin_files( 'model' );

/*** Custom Post Types */
XTW_CPTSet::xtw_cpt_add(
	'article',
	__('Article', 'xtw'),
	__('Articles Management', 'xtw'),
	'category_article',
	__('Articles Categories', 'xtw')
);

XTW_CPTSet::xtw_cpt_add(
	'videos',
	__('Video', 'xtw'),
	__('Videos Management', 'xtw')
);

XTW_CPTSet::xtw_cpt_add(
	'partners',
	__('Partner','xtw'),
	__('Partners Management', 'xtw'),
	'partners_tax',
	__('Partners Categories', 'xtw')
);

XTW_CPTSet::xtw_cpt_add(
	'downloads',
	__('Download', 'xtw'),
	__('Downloads Management', 'xtw'),
	'downloads_tax',
	__('Downloads categories', 'xtw')
);

XTW_CPTSet::xtw_cpt_add(
	'wflinks',
	__('WF Link', 'xtw'),
	__('WP Links Module Management', 'xtw'),
	'wflinks_tax',
	__('WP Links Categories')
);

new XTW_Import();

/*** Experimental */
new XTW_301_Redirects();