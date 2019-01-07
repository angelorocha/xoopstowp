<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

abstract class XTW_BBcode {

	/**
	 * @param $text
	 *
	 * @return null|string|string[]
	 */
	public static function bbcode_to_html_parser( $text ) {

		$find    = array(
			'~\[b\](.*?)\[/b\]~s',
			'~\[i\](.*?)\[/i\]~s',
			'~\[u\](.*?)\[/u\]~s',
			'~\[quote\](.*?)\[/quote\]~s',
			'~\[size=(.*?)\](.*?)\[/size\]~s',
			'~\[color=(.*?)\](.*?)\[/color\]~s',
			'@\[url=([^]]*)\]([^[]*)\[/url\]@',
			'~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s'
		);

		$replace = array(
			'<strong>$1</strong>',
			'<i>$1</i>',
			'<span style="text-decoration:underline;">$1</span>',
			'<pre>$1</' . 'pre>',
			'<span style="font-size:$1px;">$2</span>',
			'<span style="color:$1;">$2</span>',
			'<a href="$1">$2</a>',
			'<img src="$1" alt="" />'
		);

		return preg_replace( $find, $replace, $text );
	}

}