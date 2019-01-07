<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class ImportFrontEnd {

	public $object;
	public $get_data;
	public $set_data;
	public $action;

	public function __construct() {
		self::xwt_import_frontend();
	}

	public function xtw_import_object() {
		return new $this->object;
	}

	public function xtw_import_count() {
		return XTW_Query::xtw_count_table_rows( $this->get_data );
	}

	public function xtw_import_action() {
		$label = __( 'Execute Import', 'xtw' );

		return "<button type='submit' name='$this->action'>$label</button>";
	}

	public function xtw_execute_import() {
		return ( isset( $_POST[ $this->action ] ) ? $this->set_data : false );
	}

	public function xwt_import_frontend() {
		$html = __( 'Entries: ', 'xtw' ) . self::xtw_import_count();
		$html .= self::xtw_import_action();

		return $html;
	}
}