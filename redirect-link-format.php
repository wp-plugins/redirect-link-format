<?php
/**
 * Plugin Name: Redirect Link Format
 * Description: Auto-redirects link format posts to a URL specified in the content area.
 * Author: Drew Jaynes
 * Version: 1.0
 * License: GPLv2
 */

/**
 * Link Format Redirect class.
 *
 * @since 1.0
 */
class Redirect_Link_Format {

	/**
	 * Constructor.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'template_redirect', array( $this, 'template_redirect' ) );
	}

	/**
	 * Redirect the post type if it's both a link format and the content isn't empty.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function template_redirect() {
		if ( is_admin() || ! is_singular() ) {
			return;
		}

		$post = get_post();

		if ( ! $post || 'link' !== get_post_format() ) {
			return;
		}

		if ( ! empty( $post->post_content )
			&& in_array( $post->post_status, array( 'publish', 'future' ) )
		) {
			$url = esc_url_raw( $post->post_content );

			if ( wp_redirect( $url ) ) {
				exit();
			}
		}
	}
}

new Redirect_Link_Format();
