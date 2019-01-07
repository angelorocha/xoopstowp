<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

final class XTW_TaxonomyFactory{

	public $tax_key;
	public $tax_name;
	public $post_type_keys = array();

	public function __construct() {
		add_action( 'init', array( $this, 'cpt_tax_create' ) );
	}

	public function cpt_tax_labels() {
		$labels = array(
			"name"                       => _x( $this->tax_name, "Taxonomy General Name", "xtw" ),
			"singular_name"              => _x( "$this->tax_name", "Taxonomy Singular Name", "xtw" ),
			"menu_name"                  => __( "$this->tax_name", "xtw" ),
			"all_items"                  => __( "All $this->tax_name", "xtw" ),
			"parent_item"                => __( "Parent $this->tax_name", "xtw" ),
			"parent_item_colon"          => __( "Parent $this->tax_name:", "xtw" ),
			"new_item_name"              => __( "New $this->tax_name Name", "xtw" ),
			"add_new_item"               => __( "Add New $this->tax_name", "xtw" ),
			"edit_item"                  => __( "Edit $this->tax_name", "xtw" ),
			"update_item"                => __( "Update $this->tax_name", "xtw" ),
			"view_item"                  => __( "View $this->tax_name", "xtw" ),
			"separate_items_with_commas" => __( "Separate items with commas", "xtw" ),
			"add_or_remove_items"        => __( "Add or remove " . $this->tax_name . "s", "xtw" ),
			"choose_from_most_used"      => __( "Choose from the most used", "xtw" ),
			"popular_items"              => __( "Popular " . $this->tax_name . "s", "xtw" ),
			"search_items"               => __( "Search " . $this->tax_name . "s", "xtw" ),
			"not_found"                  => __( "Not Found", "xtw" ),
			"no_terms"                   => __( "No " . $this->tax_name . "s", "xtw" ),
			"items_list"                 => __( $this->tax_name . "s list", "xtw" ),
			"items_list_navigation"      => __( $this->tax_name . "s list navigation", "xtw" ),
		);

		return $labels;
	}

	public function cpt_tax_rewrite() {
		$rewrite = array(
			"slug"         => sanitize_title( $this->tax_name ),
			"with_front"   => true,
			"hierarchical" => true,
		);

		return $rewrite;
	}

	public function cpt_tax_args() {
		$args = array(
			"labels"            => self::cpt_tax_labels(),
			"hierarchical"      => true,
			"public"            => true,
			"show_ui"           => true,
			"show_admin_column" => true,
			"show_in_nav_menus" => true,
			"show_tagcloud"     => true,
			"query_var"         => $this->tax_key,
			"rewrite"           => self::cpt_tax_rewrite(),
			"show_in_rest"      => true,
		);

		return $args;
	}

	public function cpt_tax_create() {
		return register_taxonomy( $this->tax_key, $this->post_type_keys, self::cpt_tax_args() );
	}

}