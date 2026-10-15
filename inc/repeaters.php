<?php
/**
 * Default content + helpers for every repeater block.
 *
 * @package TargetWeb3
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function tw3_get_repeater( $key ) {
	$raw = get_theme_mod( $key, '' );
	if ( empty( $raw ) ) return array();
	$data = json_decode( $raw, true );
	return is_array( $data ) ? $data : array();
}

/**
 * Equipment categories. Each card opens a popup modal on click — the
 * popup_* fields are what's shown inside that modal, fully editable
 * from the Customizer with no code required.
 */
function tw3_default_categories() {
	$img = TW3_URI . '/assets/images/categories/';
	return array(
		array(
			'title' => 'Lawn Mowers', 'icon' => 'star-filled', 'image' => $img . 'lawn-mowers.svg',
			'popup_description' => "From residential push mowers to heavy-duty zero-turns, our lawn mower lineup covers every property size and terrain. Every unit is dealer-inspected and ready for pickup or delivery.",
			'popup_cta_text' => 'Request a Quote', 'popup_cta_link' => '#quote',
		),
		array(
			'title' => 'Chainsaws', 'icon' => 'admin-generic', 'image' => $img . 'chainsaws.svg',
			'popup_description' => "Homeowner to professional-grade chainsaws for storm cleanup, land clearing, and firewood processing. We stock bar and chain replacements for every model we sell.",
			'popup_cta_text' => 'Request a Quote', 'popup_cta_link' => '#quote',
		),
		array(
			'title' => 'Trimmers & Brushcutters', 'icon' => 'dismiss', 'image' => $img . 'trimmers.svg',
			'popup_description' => "String trimmers and brushcutters built for all-day use — from light residential trim work to heavy brush and overgrowth clearing on commercial properties.",
			'popup_cta_text' => 'Request a Quote', 'popup_cta_link' => '#quote',
		),
		array(
			'title' => 'Blowers', 'icon' => 'leaf', 'image' => $img . 'blowers.svg',
			'popup_description' => "Handheld and backpack blowers with the CFM and runtime to clear large properties fast. Battery and gas-powered options available.",
			'popup_cta_text' => 'Request a Quote', 'popup_cta_link' => '#quote',
		),
		array(
			'title' => 'Generators', 'icon' => 'flag', 'image' => $img . 'generators.svg',
			'popup_description' => "Portable and standby generators sized for job sites, storm backup, and off-grid power needs. We help you size the right unit for your actual load.",
			'popup_cta_text' => 'Request a Quote', 'popup_cta_link' => '#quote',
		),
		array(
			'title' => 'Commercial Equipment', 'icon' => 'awards', 'image' => $img . 'commercial.svg',
			'popup_description' => "Fleet-grade mowers, skid steers, and attachments for landscaping crews and municipalities. Fleet financing and priority service scheduling available.",
			'popup_cta_text' => 'Request a Quote', 'popup_cta_link' => '#quote',
		),
	);
}

function tw3_default_features() {
	return array(
		array( 'title' => 'Expert Guidance', 'description' => 'Our specialists help match equipment to your operation.', 'icon' => 'plus-alt2' ),
		array( 'title' => 'Fast Response', 'description' => 'Quick quotes and prompt service when you need it.', 'icon' => 'flag' ),
		array( 'title' => 'Financing Options', 'description' => 'Flexible plans to fit your budget and growth.', 'icon' => 'money-alt' ),
		array( 'title' => 'Built to Last', 'description' => 'Commercial-grade equipment from trusted brands.', 'icon' => 'shield' ),
		array( 'title' => 'Support & Service', 'description' => 'Full-service repair and parts availability.', 'icon' => 'yes-alt' ),
	);
}

function tw3_default_brands() {
	return array(
		array( 'name' => 'Honda', 'logo' => '' ),
		array( 'name' => 'Kawasaki', 'logo' => '' ),
		array( 'name' => 'Kohler', 'logo' => '' ),
		array( 'name' => 'Generac', 'logo' => '' ),
		array( 'name' => 'Echo', 'logo' => '' ),
	);
}

/* ---------------------------------------------------------------
 * Sanitizers
 * --------------------------------------------------------------- */

function tw3_sanitize_categories_repeater( $json ) {
	$rows = json_decode( $json, true );
	if ( ! is_array( $rows ) ) return wp_json_encode( array() );
	$clean = array();
	foreach ( $rows as $row ) {
		$clean[] = array(
			'title'             => sanitize_text_field( $row['title'] ?? '' ),
			'icon'              => sanitize_html_class( $row['icon'] ?? '' ),
			'image'             => esc_url_raw( $row['image'] ?? '' ),
			'popup_description' => sanitize_textarea_field( $row['popup_description'] ?? '' ),
			'popup_cta_text'    => sanitize_text_field( $row['popup_cta_text'] ?? 'Request a Quote' ),
			'popup_cta_link'    => sanitize_text_field( $row['popup_cta_link'] ?? '#quote' ),
		);
	}
	return wp_json_encode( $clean );
}

function tw3_sanitize_features_repeater( $json ) {
	$rows = json_decode( $json, true );
	if ( ! is_array( $rows ) ) return wp_json_encode( array() );
	$clean = array();
	foreach ( $rows as $row ) {
		$clean[] = array(
			'title'       => sanitize_text_field( $row['title'] ?? '' ),
			'description' => sanitize_textarea_field( $row['description'] ?? '' ),
			'icon'        => sanitize_html_class( $row['icon'] ?? '' ),
		);
	}
	return wp_json_encode( $clean );
}

function tw3_sanitize_brands_repeater( $json ) {
	$rows = json_decode( $json, true );
	if ( ! is_array( $rows ) ) return wp_json_encode( array() );
	$clean = array();
	foreach ( $rows as $row ) {
		$clean[] = array(
			'name' => sanitize_text_field( $row['name'] ?? '' ),
			'logo' => esc_url_raw( $row['logo'] ?? '' ),
		);
	}
	return wp_json_encode( $clean );
}

/**
 * Curated icon set for icon-picker fields.
 */
function tw3_icon_choices() {
	return array(
		'star-filled', 'admin-generic', 'dismiss', 'leaf', 'flag', 'awards',
		'plus-alt2', 'money-alt', 'shield', 'yes-alt', 'admin-tools', 'car',
		'location-alt', 'phone', 'email', 'clock', 'performance', 'admin-home',
		'arrow-up-alt2', 'arrow-right-alt2', 'groups', 'store',
	);
}

/* ---------------------------------------------------------------
 * Homepage section order / visibility
 * --------------------------------------------------------------- */

function tw3_section_registry() {
	return array(
		'hero'        => array( 'label' => 'Hero',                  'template' => 'hero' ),
		'categories'  => array( 'label' => 'Equipment Categories',   'template' => 'categories' ),
		'brands'      => array( 'label' => 'Brand Wall',             'template' => 'brand-strip' ),
		'why_us'      => array( 'label' => 'Why Choose Us',          'template' => 'why-us' ),
		'quote'       => array( 'label' => 'Quote Form',             'template' => 'quote' ),
		'trust_row'   => array( 'label' => 'Mini Trust Row',         'template' => 'trust-row' ),
		'cta_banner'  => array( 'label' => 'CTA Banner',             'template' => 'cta-banner' ),
	);
}

function tw3_default_section_order() {
	$order = array();
	foreach ( array_keys( tw3_section_registry() ) as $id ) {
		$order[] = array( 'id' => $id, 'enabled' => true );
	}
	return $order;
}

function tw3_get_section_order() {
	$raw = get_theme_mod( 'tw3_section_order', '' );
	$saved = json_decode( $raw, true );
	$registry = tw3_section_registry();

	if ( ! is_array( $saved ) ) return tw3_default_section_order();

	$seen = array();
	$clean = array();
	foreach ( $saved as $row ) {
		$id = $row['id'] ?? '';
		if ( ! isset( $registry[ $id ] ) || isset( $seen[ $id ] ) ) continue;
		$seen[ $id ] = true;
		$clean[] = array( 'id' => $id, 'enabled' => ! empty( $row['enabled'] ) );
	}
	foreach ( array_keys( $registry ) as $id ) {
		if ( ! isset( $seen[ $id ] ) ) $clean[] = array( 'id' => $id, 'enabled' => true );
	}
	return $clean;
}

function tw3_sanitize_section_order( $json ) {
	$rows = json_decode( $json, true );
	$registry = tw3_section_registry();
	if ( ! is_array( $rows ) ) return wp_json_encode( tw3_default_section_order() );

	$seen = array();
	$clean = array();
	foreach ( $rows as $row ) {
		$id = sanitize_key( $row['id'] ?? '' );
		if ( ! isset( $registry[ $id ] ) || isset( $seen[ $id ] ) ) continue;
		$seen[ $id ] = true;
		$clean[] = array( 'id' => $id, 'enabled' => ! empty( $row['enabled'] ) );
	}
	foreach ( array_keys( $registry ) as $id ) {
		if ( ! isset( $seen[ $id ] ) ) $clean[] = array( 'id' => $id, 'enabled' => true );
	}
	return wp_json_encode( $clean );
}
