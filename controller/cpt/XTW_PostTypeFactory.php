<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

final class XTW_PostTypeFactory {
	public $post_type_key;
	public $post_type_name;
	public $post_type_desc;

	public function __construct() {
		add_action( 'init', array( $this, 'cpt_create' ) );
	}

	public function cpt_set_labels() {
		$labels = array(
			'name'                  => _x( $this->post_type_name . "s", "Post Type General Name", "xtw" ),
			'singular_name'         => _x( "$this->post_type_name", "Post Type Singular Name", "xtw" ),
			'menu_name'             => __( $this->post_type_name . "s", "xtw" ),
			'name_admin_bar'        => __( "$this->post_type_name", "xtw" ),
			'archives'              => __( "$this->post_type_name Archives", "xtw" ),
			'attributes'            => __( "$this->post_type_name Attributes", "xtw" ),
			'parent_item_colon'     => __( "Parent $this->post_type_name:", "xtw" ),
			'all_items'             => __( "All $this->post_type_name", "xtw" ),
			'add_new_item'          => __( "Add New $this->post_type_name", "xtw" ),
			'add_new'               => __( "Add New", "xtw" ),
			'new_item'              => __( "New $this->post_type_name", "xtw" ),
			'edit_item'             => __( "Edit $this->post_type_name", "xtw" ),
			'update_item'           => __( "Update $this->post_type_name", "xtw" ),
			'view_item'             => __( "View $this->post_type_name", "xtw" ),
			'view_items'            => __( "View" . $this->post_type_name . "s", "xtw" ),
			'search_items'          => __( "Search $this->post_type_name", "xtw" ),
			'not_found'             => __( "Not found", "xtw" ),
			'not_found_in_trash'    => __( "Not found in Trash", "xtw" ),
			'featured_image'        => __( "Featured Image", "xtw" ),
			'set_featured_image'    => __( "Set featured image", "xtw" ),
			'remove_featured_image' => __( "Remove featured image", "xtw" ),
			'use_featured_image'    => __( "Use as featured image", "xtw" ),
			'insert_into_item'      => __( "\Insert into item", "xtw" ),
			'uploaded_to_this_item' => __( "Uploaded to this item", "xtw" ),
			'items_list'            => __( "Items list", "xtw" ),
			'items_list_navigation' => __( "Items list navigation", "xtw" ),
			'filter_items_list'     => __( "Filter items list", "xtw" ),
		);

		return $labels;
	}

	public function cpt_rewrite_rules() {
		$rewrite = array(
			'slug'       => sanitize_title( $this->post_type_name ),
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		return $rewrite;
	}

	public function cpt_supports() {
		$supports = array(
			'title',
			'editor',
			'thumbnail',
			'comments',
			'trackbacks',
			'revisions',
			'custom-fields',
			'page-attributes',
			'post-formats'
		);

		return $supports;
	}

	public function cpt_args() {
		$args = array(
			'label'               => __( "$this->post_type_name", "xtw" ),
			'description'         => __( "$this->post_type_desc", "xtw" ),
			'labels'              => self::cpt_set_labels(),
			'supports'            => self::cpt_supports(),
			#'taxonomies'          => array( 'cpt_taxonomy' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-star-filled',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'query_var'           => $this->post_type_key,
			'rewrite'             => self::cpt_rewrite_rules(),
			'capability_type'     => 'post',
			'show_in_rest'        => true,
		);

		return $args;
	}

	public function cpt_create() {
		return register_post_type( $this->post_type_key, self::cpt_args() );
	}
}