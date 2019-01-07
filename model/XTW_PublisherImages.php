<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

class XTW_PublisherImages {
	public function xtw_publisher_images() {

		$prefix          = XTW_XPS_Modules_Check::xtw_get_xoops_tables( true );
		$publisher_items = $prefix . 'publisher_items';
		$xoops_images    = $prefix . 'image';

		$query = "
			SELECT
				itemid as _publisher_old_id, 
				$xoops_images.image_name as thumbnail
			FROM $publisher_items
			INNER JOIN $xoops_images ON $xoops_images.image_id = $publisher_items.image;
		";

		return XTW_Query::xtw_make_query( $query );
	}

	public function xtw_publisher_set_thumbnail() {
		foreach ( self::xtw_publisher_images() as $image => $key ):
			$check_post = XTW_Query::xtw_get_old_id( 0, $key->_publisher_old_id, '_publisher_old_id' );
			$old_image  = XTW_XoopsUrl::xtw_xoops_home_url() . '/uploads/' . $key->thumbnail;
			if ( $check_post ):
				XTW_SetThumb::xtw_insert_thumbnail( $old_image, $check_post );
			endif;
		endforeach;
	}
}