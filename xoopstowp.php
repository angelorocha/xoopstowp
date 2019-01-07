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
XTW_CPTSet::xtw_cpt_add( 'article', 'Artigo', 'Gerenciador de Artigos', 'category_article', 'Categoria Artigos' );
XTW_CPTSet::xtw_cpt_add( 'videos', 'Vídeo', 'Gerenciador de Vídeos' );
XTW_CPTSet::xtw_cpt_add( 'parceiros', 'Parceiro', 'Gerenciador de Parceiros', 'parceiros_tax', 'Categoria Parceiros' );
XTW_CPTSet::xtw_cpt_add( 'downloads', 'Download', 'Gerenciador de Downloads', 'downloads_tax', 'Categoria Downloads' );
XTW_CPTSet::xtw_cpt_add( 'wflinks', 'Diretorio', 'Gerenciador de Diretorio de Endereços', 'wflinks_tax', 'Categoria Links' );

new XTW_Import();

/*** Experimental */
#new XTW_301_Redirects();