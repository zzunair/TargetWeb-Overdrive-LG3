<?php
/**
 * Small reusable output helpers.
 *
 * @package TargetWeb3
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function tw3_icon( $name, $class = '' ) {
	if ( empty( $name ) ) return;
	echo '<span class="dashicons dashicons-' . esc_attr( $name ) . ' ' . esc_attr( $class ) . '"></span>';
}

function tw3_social_icons() {
	$socials = array(
		'facebook'  => array( tw3_opt( 'tw3_social_facebook' ), 'facebook-alt' ),
		'instagram' => array( tw3_opt( 'tw3_social_instagram' ), 'instagram' ),
		'youtube'   => array( tw3_opt( 'tw3_social_youtube' ), 'youtube' ),
		'linkedin'  => array( tw3_opt( 'tw3_social_linkedin' ), 'linkedin' ),
	);
	foreach ( $socials as $key => $data ) {
		list( $url, $icon ) = $data;
		if ( empty( $url ) ) continue;
		printf(
			'<a class="tw3-social-icon" href="%s" target="_blank" rel="noopener noreferrer" aria-label="%s"><span class="dashicons dashicons-%s"></span></a>',
			esc_url( $url ), esc_attr( ucfirst( $key ) ), esc_attr( $icon )
		);
	}
}

function tw3_meta( $post_id, $key, $default = '' ) {
	$val = get_post_meta( $post_id, $key, true );
	return ( '' === $val || false === $val ) ? $default : $val;
}
