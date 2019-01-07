<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

final class XTW_Import {

	private $version = '20180913';

	public function __construct() {
		defined( 'ABSPATH' ) or die( 'Oooooh Boy...' );
		add_action( 'admin_menu', array( $this, 'xtw_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'xtw_register_options' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'xtw_enqueue_style' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'xtw_enqueue_script' ) );
	}

	public function xtw_admin_menu() {
		add_menu_page(
			'XOOPS To WP',
			'XOOPS To WP',
			'administrator',
			'xoops-to-wordpress-import',
			array( $this, 'xtw_admin_page_content' ),
			'dashicons-update',
			5
		);
	}

	public function xtw_admin_page_content() {
		require_once dirname( __DIR__ ) . '/view/template.php';
	}

	public function xtw_register_options() {
		register_setting( 'xtw_options_group', 'xtw_cpt_name', self::xtw_sanitize_options( 'string', 0 ) );
		register_setting( 'xtw_options_group', 'xtw_execute_time', self::xtw_sanitize_options( 'boolean', 0 ) );
	}

	/**
	 * @param $input_id
	 * @param $label
	 * @param string $type
	 * @param null $desc
	 * @param string $value
	 * @param bool $single
	 *
	 * @return string
	 */
	public static function xtw_set_input( $input_id, $label, $type = "text", $desc = null, $value = '', $single = true ) {
		$attr = null;
		if ( $type === 'checkbox' || $type === 'radio' ):
			$attr = ( ! empty( get_option( $input_id ) ) ? ' checked' : false );
		endif;
		if ( $type === 'text' && ! empty( get_option( $input_id ) ) ):
			$value = get_option( $input_id );
		endif;

		$input = "<tr><td>";
		$input .= "<label for='$input_id'>$label <small>$desc</small></label>";
		$input .= "</td>";
		$input .= "<td>";
		if ( $single ):
			$input .= "<input type='$type' name='$input_id' id='$input_id' value='$value'$attr>";
		endif;
		if ( ! $single ):
			$input .= "<input type='$type' name='$input_id' id='$input_id' value='$value'$attr>";
		endif;
		$input .= "</td></tr>";

		return $input;
	}

	/**
	 * @param string $type = Valid values are 'string', 'boolean', 'integer', and 'number'.
	 * @param string $default
	 *
	 * @return array
	 */
	public function xtw_sanitize_options( $type = 'string', $default = '' ) {
		$input = array(
			'type'              => $type,
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => $default
		);

		return $input;
	}

	public function xtw_enqueue_style() {
		wp_enqueue_style( 'xtw-style', plugin_dir_url( __DIR__ ) . 'css/style.css', array(), $this->version, false );
	}

	public function xtw_enqueue_script() {
		wp_enqueue_script( 'xtw-script', plugin_dir_url( __DIR__ ) . 'js/js.js', array( 'jquery' ), $this->version, true );
	}

	public function xtw_plugin_text_domain() {
		load_plugin_textdomain( 'xtw', false, basename( dirname( __FILE__ ) ) . '/lang/' );
	}

	public static function xtw_autoload_plugin_files( $dir ) {
		$plugin_dir = plugin_dir_path( __DIR__ );

		foreach ( glob( $plugin_dir . "$dir/*.php" ) as $file ):
			require_once "$file";
		endforeach;
	}

	public static function xtw_get_view( $view ) {
		$plugin_dir = plugin_dir_path( __DIR__ ) . 'view/';
		$view_file  = include_once $plugin_dir . $view . '.php';

		return $view_file;
	}
}