<?php
/**
 * Built-in SEO. Steps aside when an SEO plugin is active.
 *
 * @package TargetWeb3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tw3_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' ) || defined( 'THE_SEO_FRAMEWORK_VERSION' ) || defined( 'SLIM_SEO_VER' );
}

function tw3_seo_enabled() {
	$on = get_theme_mod( 'tw3_seo_on', true );
	return $on && ! tw3_seo_plugin_active();
}

add_filter(
	'wp_robots',
	function ( $robots ) {
		$flags = array( 'tw3_quote', 's' );
		foreach ( array_keys( $_GET ) as $key ) { // phpcs:ignore WordPress.Security.NonceVerification
			if ( in_array( sanitize_key( $key ), $flags, true ) ) {
				$robots['noindex'] = true;
				$robots['follow']  = true;
				unset( $robots['index'] );
				return $robots;
			}
		}
		if ( is_search() || is_404() ) {
			$robots['noindex'] = true;
			$robots['follow']  = true;
		}
		return $robots;
	}
);

function tw3_seo_description() {
	$description = '';
	if ( is_singular() ) {
		$description = has_excerpt() ? get_the_excerpt() : wp_strip_all_tags( strip_shortcodes( (string) get_post_field( 'post_content' ) ) );
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$description = wp_strip_all_tags( term_description() );
	}
	if ( ! $description ) {
		$description = tw3_opt( 'tw3_seo_desc' );
	}
	if ( ! $description ) {
		$description = get_bloginfo( 'description' );
	}
	if ( ! $description ) {
		$description = tw3_opt( 'tw3_footer_tagline' );
	}
	return wp_trim_words( trim( preg_replace( '/\s+/', ' ', (string) $description ) ), 32, '…' );
}

function tw3_seo_canonical() {
	if ( is_front_page() ) {
		return home_url( '/' );
	}
	if ( is_singular() ) {
		return get_permalink();
	}
	if ( is_category() || is_tag() || is_tax() ) {
		$link = get_term_link( get_queried_object() );
		return is_wp_error( $link ) ? '' : $link;
	}
	if ( is_home() && get_option( 'page_for_posts' ) ) {
		return get_permalink( (int) get_option( 'page_for_posts' ) );
	}
	if ( is_search() || is_404() ) {
		return '';
	}
	return home_url( '/' );
}

function tw3_seo_image() {
	if ( is_singular() && has_post_thumbnail() ) {
		return get_the_post_thumbnail_url( null, 'large' );
	}
	$url = tw3_opt( 'tw3_seo_image' );
	if ( $url ) {
		return $url;
	}
	$logo = get_theme_mod( 'custom_logo' );
	return $logo ? wp_get_attachment_image_url( (int) $logo, 'large' ) : '';
}

function tw3_seo_customize( $wp_customize ) {
	$wp_customize->add_section(
		'tw3_sec_seo',
		array(
			'title'       => __( 'SEO', 'targetweb3' ),
			'panel'       => 'tw3_panel',
			'priority'    => 70,
			'description' => __( 'Adds the description, social preview, and business details. This turns itself off when Yoast, Rank Math, AIOSEO, SEOPress, The SEO Framework, or Slim SEO is active.', 'targetweb3' ),
		)
	);

	$wp_customize->add_setting( 'tw3_seo_on', array( 'default' => true, 'sanitize_callback' => 'wp_validate_boolean' ) );
	$wp_customize->add_control( 'tw3_seo_on', array( 'label' => __( 'Enable built-in SEO', 'targetweb3' ), 'section' => 'tw3_sec_seo', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'tw3_seo_desc', array( 'default' => tw3_text_default( 'tw3_seo_desc' ), 'sanitize_callback' => 'sanitize_textarea_field' ) );
	$wp_customize->add_control( 'tw3_seo_desc', array( 'label' => __( 'Default description', 'targetweb3' ), 'description' => __( 'Used on the homepage and on pages that have no excerpt.', 'targetweb3' ), 'section' => 'tw3_sec_seo', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'tw3_seo_image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'tw3_seo_image', array( 'label' => __( 'Social share image', 'targetweb3' ), 'section' => 'tw3_sec_seo' ) ) );
}
add_action( 'customize_register', 'tw3_seo_customize', 20 );

add_action(
	'wp_head',
	function () {
		if ( ! tw3_seo_enabled() || is_customize_preview() ) {
			return;
		}
		remove_action( 'wp_head', 'rel_canonical' );

		$description = tw3_seo_description();
		$canonical   = tw3_seo_canonical();
		$title       = wp_get_document_title();
		$image       = tw3_seo_image();
		$type        = is_singular( 'post' ) ? 'article' : 'website';

		if ( $canonical ) {
			$paged = (int) get_query_var( 'paged' );
			if ( $paged > 1 && ! is_singular() ) {
				$canonical = strtok( get_pagenum_link( $paged ), '?' );
			}
			echo '<link rel="canonical" href="' . esc_url( $canonical ) . '">' . "\n";
		}
		if ( $description ) {
			echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
		}

		$open_graph = array(
			'og:locale'      => get_locale(),
			'og:type'        => $type,
			'og:title'       => $title,
			'og:description' => $description,
			'og:url'         => $canonical,
			'og:site_name'   => get_bloginfo( 'name' ),
			'og:image'       => $image,
		);
		foreach ( $open_graph as $key => $value ) {
			if ( $value ) {
				echo '<meta property="' . esc_attr( $key ) . '" content="' . esc_attr( $value ) . '">' . "\n";
			}
		}

		$twitter = array(
			'twitter:card'        => $image ? 'summary_large_image' : 'summary',
			'twitter:title'       => $title,
			'twitter:description' => $description,
			'twitter:image'       => $image,
		);
		foreach ( $twitter as $key => $value ) {
			if ( $value ) {
				echo '<meta name="' . esc_attr( $key ) . '" content="' . esc_attr( $value ) . '">' . "\n";
			}
		}

		if ( is_front_page() ) {
			$same = array_values( array_filter( array( tw3_opt( 'tw3_social_facebook' ), tw3_opt( 'tw3_social_instagram' ), tw3_opt( 'tw3_social_youtube' ), tw3_opt( 'tw3_social_linkedin' ) ) ) );
			$business = array_filter(
				array(
					'@context'  => 'https://schema.org',
					'@type'     => 'LocalBusiness',
					'@id'       => home_url( '/#business' ),
					'name'      => get_bloginfo( 'name' ),
					'url'       => home_url( '/' ),
					'telephone' => tw3_opt( 'tw3_contact_phone_display' ),
					'email'     => tw3_opt( 'tw3_contact_email' ),
					'image'     => $image,
					'address'   => array(
						'@type'         => 'PostalAddress',
						'streetAddress' => tw3_opt( 'tw3_contact_address' ),
					),
					'sameAs'    => $same,
				)
			);
			echo '<script type="application/ld+json">' . wp_json_encode( $business, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP ) . '</script>' . "\n";
			echo '<script type="application/ld+json">' . wp_json_encode(
				array_filter(
					array(
						'@context' => 'https://schema.org',
						'@type'    => 'WebSite',
						'name'     => get_bloginfo( 'name' ),
						'url'      => home_url( '/' ),
					)
				),
				JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP
			) . '</script>' . "\n";
		}
	},
	1
);
