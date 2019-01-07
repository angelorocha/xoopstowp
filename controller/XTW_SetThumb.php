<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

abstract class XTW_SetThumb {

	/**
	 * @param $image_url
	 * @param $post_id
	 */
	public static function xtw_insert_thumbnail( $image_url, $post_id ) {

		$file     = self::xtw_get_image( $image_url, $post_id )['path'];
		$filename = self::xtw_get_image( $image_url, $post_id )['name'];
		$filetype = self::xtw_get_image( $image_url, $post_id )['url'];

		$wp_filetype = wp_check_filetype( $filetype, null );
		$attachment  = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => sanitize_file_name( $filename ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);
		$attach_id   = wp_insert_attachment( $attachment, $file, $post_id );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
		wp_update_attachment_metadata( $attach_id, $attach_data );
		set_post_thumbnail( $post_id, $attach_id );
	}

	/**
	 * @param $content
	 *
	 * @return mixed
	 */
	public static function xtw_get_content_images( $content ) {
		$content_html = new DOMDocument();
		@$content_html->loadHTML( $content );
		$images       = $content_html->getElementsByTagName( 'img' );
		$check_images = count( $images ) > 0 ? true : false;
		$get_images   = array();
		$new_img_url  = array();
		$count_images = 0;

		if ( $check_images ):
			foreach ( $images as $image ):
				$get_images[]  = $image->getAttribute( 'src' );
				$new_img_url[] = self::xtw_get_image( $get_images[ $count_images ] )['url'];
				$count_images ++;
			endforeach;
			$count_images = 0;
		endif;

		$new_content = str_ireplace( $get_images, $new_img_url, $content );

		return ( $check_images ? $new_content : $content );
	}

	/**
	 * @param $image_url
	 * @param null $image_id
	 *
	 * @return array
	 */
	public static function xtw_get_image( $image_url, $image_id = null ) {

		$ch = curl_init( $image_url );

		$upload_dir = wp_upload_dir();
		$image_ext  = pathinfo( $image_url )['extension'];
		$image_name = ( is_null( $image_id ) ? basename( $image_url ) : sanitize_title( get_the_title( $image_id ) ) . '.' . $image_ext );
		$image_path = $upload_dir['path'] . '/' . $image_name;
		$image_url  = $upload_dir['url'] . '/' . $image_name;

		$fp = fopen( $image_path, 'wb' );
		curl_setopt( $ch, CURLOPT_FILE, $fp );
		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)' );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 0 );
		curl_setopt( $ch, CURLOPT_TIMEOUT, 900 );
		curl_exec( $ch );
		curl_close( $ch );
		fclose( $fp );

		$image = array(
			'path' => $image_path,
			'name' => $image_name,
			'url'  => $image_url
		);

		return $image;
	}
}