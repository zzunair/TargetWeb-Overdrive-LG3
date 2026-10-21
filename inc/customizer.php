<?php
/**
 * TargetWeb 3 Customizer.
 *
 * @package TargetWeb3
 */

if ( ! defined( 'ABSPATH' ) ) exit;

require_once TW3_DIR . '/inc/class-repeater-control.php';
require_once TW3_DIR . '/inc/class-section-order-control.php';

function tw3_register_repeater( $wp_customize, $section, $setting_id, $default, $sanitize_cb, $schema, $item_label, $label, $priority = 10, $max_items = 0 ) {
	$wp_customize->add_setting( $setting_id, array(
		'default'           => wp_json_encode( $default ),
		'sanitize_callback' => $sanitize_cb,
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new TW3_Repeater_Control( $wp_customize, $setting_id, array(
		'section'    => $section,
		'label'      => $label,
		'schema'     => $schema,
		'item_label' => $item_label,
		'priority'   => $priority,
		'max_items'  => $max_items,
	) ) );
}

function tw3_register_fields( $wp_customize, $section, $fields, $priority_start = 10 ) {
	$i = $priority_start;
	foreach ( $fields as $id => $f ) {
		$type = isset( $f['type'] ) ? $f['type'] : 'text';
		$default = tw3_text_default( $id );
		if ( '' === $default && isset( $f['default'] ) ) $default = $f['default'];

		$sanitize = 'sanitize_text_field';
		if ( 'textarea' === $type ) $sanitize = 'sanitize_textarea_field';
		if ( 'url' === $type )      $sanitize = 'esc_url_raw';
		if ( 'number' === $type )   $sanitize = 'absint';
		if ( 'email' === $type )    $sanitize = 'sanitize_email';

		$wp_customize->add_setting( $id, array(
			'default'           => $default,
			'sanitize_callback' => $sanitize,
			'transport'         => 'refresh',
		) );

		$control_type = ( 'textarea' === $type ) ? 'textarea' : ( 'number' === $type ? 'number' : 'text' );

		$wp_customize->add_control( $id, array(
			'label'       => $f['label'],
			'section'     => $section,
			'type'        => $control_type,
			'description' => isset( $f['description'] ) ? $f['description'] : '',
			'priority'    => $i,
		) );
		$i += 10;
	}
}

function tw3_customize_register( $wp_customize ) {

	/* ================= PANEL ================= */
	$wp_customize->add_panel( 'tw3_panel', array(
		'title'       => __( '⚙ TargetWeb - Overdrive Theme Options', 'targetweb3' ),
		'description' => __( 'Every section of the homepage is editable here — colors, hero, categories (with click-to-open popups), brands, why-us, quote form, and footer. No code needed.', 'targetweb3' ),
		'priority'    => 1,
	) );

	/* ================= SECTION ORDER ================= */
	$wp_customize->add_section( 'tw3_sec_order', array(
		'title'       => __( '↕ Homepage Section Order', 'targetweb3' ),
		'panel'       => 'tw3_panel',
		'priority'    => 2,
		'description' => __( 'Reorder with ↑ / ↓, or uncheck a section to hide it.', 'targetweb3' ),
	) );
	$section_items = array();
	foreach ( tw3_section_registry() as $id => $info ) {
		$section_items[ $id ] = $info['label'];
	}
	$wp_customize->add_setting( 'tw3_section_order', array(
		'default'           => wp_json_encode( tw3_default_section_order() ),
		'sanitize_callback' => 'tw3_sanitize_section_order',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new TW3_Section_Order_Control( $wp_customize, 'tw3_section_order', array(
		'section' => 'tw3_sec_order',
		'label'   => __( 'Section Order', 'targetweb3' ),
		'items'   => $section_items,
	) ) );

	/* ================= COLORS ================= */
	$wp_customize->add_section( 'tw3_sec_colors', array( 'title' => __( 'Colors', 'targetweb3' ), 'panel' => 'tw3_panel', 'priority' => 5 ) );
	$colors = array(
		'tw3_color_dark'          => array( 'Background — Dark',            '#0D110D' ),
		'tw3_color_dark_alt'      => array( 'Background — Dark Card',       '#141810' ),
		'tw3_color_light'         => array( 'Background — Light Section',   '#F4F5F1' ),
		'tw3_color_light_alt'     => array( 'Background — Light Card',      '#E9EBE4' ),
		'tw3_color_green'         => array( 'Primary Green (buttons)',      '#2F7D46' ),
		'tw3_color_green_bright'  => array( 'Bright Green (accent text)',   '#4CAF50' ),
		'tw3_color_text_dark'     => array( 'Body Text (on light bg)',      '#151A13' ),
		'tw3_color_text_onlight_muted' => array( 'Muted Text (on light bg)','#5B6058' ),
		'tw3_color_text_ondark_muted'  => array( 'Muted Text (on dark bg)', '#9CA39A' ),
		'tw3_color_border_light'  => array( 'Borders (on light bg)',        '#DEE1D7' ),
	);
	$p = 10;
	foreach ( $colors as $id => $c ) {
		$wp_customize->add_setting( $id, array( 'default' => $c[1], 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'refresh' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array( 'label' => $c[0], 'section' => 'tw3_sec_colors', 'priority' => $p ) ) );
		$p += 10;
	}

	/* ================= HEADER ================= */
	$wp_customize->add_section( 'tw3_sec_header', array( 'title' => __( 'Header', 'targetweb3' ), 'panel' => 'tw3_panel', 'priority' => 10 ) );
	tw3_register_fields( $wp_customize, 'tw3_sec_header', array(
		'tw3_header_cta_text' => array( 'label' => 'Header button text', 'default' => 'Get a Quote' ),
		'tw3_header_cta_link' => array( 'label' => 'Header button link', 'default' => '#quote', 'type' => 'url' ),
	) );

	/* ================= HERO ================= */
	$wp_customize->add_section( 'tw3_sec_hero', array( 'title' => __( 'Hero Section', 'targetweb3' ), 'panel' => 'tw3_panel', 'priority' => 15 ) );
	tw3_register_fields( $wp_customize, 'tw3_sec_hero', array(
		'tw3_hero_eyebrow'       => array( 'label' => 'Eyebrow', 'default' => 'Outdoor Power Equipment' ),
		'tw3_hero_heading_line1' => array( 'label' => 'Heading — line 1 (white)', 'default' => 'Powerful' ),
		'tw3_hero_heading_line2' => array( 'label' => 'Heading — line 2 (white)', 'default' => 'Equipment.' ),
		'tw3_hero_heading_green' => array( 'label' => 'Heading — line 3 (green)', 'default' => 'Built to Perform.' ),
		'tw3_hero_subtext'       => array( 'label' => 'Subheading paragraph', 'type' => 'textarea', 'default' => 'High-quality outdoor power equipment from trusted brands. Reliable, durable, and ready to work.' ),
		'tw3_hero_btn1_text'     => array( 'label' => 'Primary button text', 'default' => 'Get a Quote' ),
		'tw3_hero_btn1_link'     => array( 'label' => 'Primary button link', 'default' => '#quote', 'type' => 'url' ),
		'tw3_hero_btn2_text'     => array( 'label' => 'Secondary button text', 'default' => 'Browse Equipment' ),
		'tw3_hero_btn2_link'     => array( 'label' => 'Secondary button link', 'default' => '#equipment', 'type' => 'url' ),
		'tw3_hero_scroll_text'   => array( 'label' => 'Scroll indicator text', 'default' => 'Scroll' ),
	) );
	$wp_customize->add_setting( 'tw3_hero_image', array( 'default' => tw3_text_default( 'tw3_hero_image' ), 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'tw3_hero_image', array(
		'label' => __( 'Hero background photo', 'targetweb3' ), 'section' => 'tw3_sec_hero', 'priority' => 200,
	) ) );

	/* ================= SECTION TITLES ================= */
	$wp_customize->add_section( 'tw3_sec_headings', array( 'title' => __( 'Section Titles', 'targetweb3' ), 'panel' => 'tw3_panel', 'priority' => 20 ) );
	tw3_register_fields( $wp_customize, 'tw3_sec_headings', array(
		'tw3_cat_eyebrow'   => array( 'label' => 'Categories — eyebrow', 'default' => 'Categories' ),
		'tw3_cat_heading'   => array( 'label' => 'Categories — heading', 'default' => 'Explore Our Equipment' ),
		'tw3_cat_sub'       => array( 'label' => 'Categories — subtext', 'type' => 'textarea', 'default' => 'Browse our full lineup of commercial-grade outdoor power equipment.' ),
		'tw3_brand_heading' => array( 'label' => 'Brand wall — heading', 'default' => 'Trusted Brands. Proven Performance.' ),
		'tw3_whyus_eyebrow' => array( 'label' => 'Why Us — eyebrow', 'default' => 'Why Us' ),
		'tw3_whyus_heading' => array( 'label' => 'Why Us — heading', 'default' => 'Why Choose Wholegoods?' ),
		'tw3_whyus_sub'     => array( 'label' => 'Why Us — subtext', 'type' => 'textarea', 'default' => 'We deliver expert guidance, premium equipment, and lasting support.' ),
		'tw3_quote_eyebrow' => array( 'label' => 'Quote — eyebrow', 'default' => 'Lead Generation' ),
		'tw3_quote_heading' => array( 'label' => 'Quote — heading', 'default' => 'Get a Quote Today' ),
		'tw3_quote_sub'     => array( 'label' => 'Quote — subtext', 'type' => 'textarea', 'default' => 'Tell us what you need and our team will get back to you with the best solution.' ),
	) );

	/* ================= EQUIPMENT CATEGORIES (repeater, with popup content) ================= */
	$wp_customize->add_section( 'tw3_sec_categories', array( 'title' => __( '🧩 Equipment Categories', 'targetweb3' ), 'panel' => 'tw3_panel', 'priority' => 24,
		'description' => __( 'Each card opens a popup with these details when clicked on the site. Add, remove, and reorder freely.', 'targetweb3' ) ) );
	tw3_register_repeater( $wp_customize, 'tw3_sec_categories', 'tw3_categories_repeater', tw3_default_categories(), 'tw3_sanitize_categories_repeater',
		array(
			array( 'key' => 'title', 'label' => 'Name', 'type' => 'text' ),
			array( 'key' => 'image', 'label' => 'Card Photo', 'type' => 'image' ),
			array( 'key' => 'icon', 'label' => 'Corner Icon (choose "None" to remove it)', 'type' => 'icon' ),
			array( 'key' => 'popup_description', 'label' => 'Popup: Description', 'type' => 'textarea' ),
			array( 'key' => 'popup_cta_text', 'label' => 'Popup: Button Text', 'type' => 'text' ),
			array( 'key' => 'popup_cta_link', 'label' => 'Popup: Button Link', 'type' => 'url' ),
		),
		'Category', __( 'Categories', 'targetweb3' ), 10, 12
	);

	/* ================= BRANDS (repeater) ================= */
	$wp_customize->add_section( 'tw3_sec_brands', array( 'title' => __( '🧩 Brand Wall', 'targetweb3' ), 'panel' => 'tw3_panel', 'priority' => 26,
		'description' => __( 'The brand names / logos shown in the dark strip. Upload a logo to replace the plain text name.', 'targetweb3' ) ) );
	tw3_register_repeater( $wp_customize, 'tw3_sec_brands', 'tw3_brands_repeater', tw3_default_brands(), 'tw3_sanitize_brands_repeater',
		array(
			array( 'key' => 'name', 'label' => 'Brand Name', 'type' => 'text' ),
			array( 'key' => 'logo', 'label' => 'Logo (optional — overrides the text name)', 'type' => 'image' ),
		),
		'Brand', __( 'Brands', 'targetweb3' ), 10, 12
	);

	/* ================= WHY US (repeater) ================= */
	$wp_customize->add_section( 'tw3_sec_features', array( 'title' => __( '🧩 Why Choose Us Tiles', 'targetweb3' ), 'panel' => 'tw3_panel', 'priority' => 28,
		'description' => __( 'Add, remove, and reorder the feature tiles.', 'targetweb3' ) ) );
	tw3_register_repeater( $wp_customize, 'tw3_sec_features', 'tw3_features_repeater', tw3_default_features(), 'tw3_sanitize_features_repeater',
		array(
			array( 'key' => 'title', 'label' => 'Title', 'type' => 'text' ),
			array( 'key' => 'description', 'label' => 'Description', 'type' => 'textarea' ),
			array( 'key' => 'icon', 'label' => 'Icon (choose "None" to remove it)', 'type' => 'icon' ),
		),
		'Feature', __( 'Features', 'targetweb3' ), 10, 12
	);

	/* ================= QUOTE FORM ================= */
	$wp_customize->add_section( 'tw3_sec_quote', array( 'title' => __( 'Quote Form', 'targetweb3' ), 'panel' => 'tw3_panel', 'priority' => 32 ) );
	tw3_register_fields( $wp_customize, 'tw3_sec_quote', array(
		'tw3_quote_equipment_options' => array( 'label' => '"Equipment Needed" dropdown — one option per line', 'type' => 'textarea', 'default' => "Lawn Mowers\nChainsaws\nTrimmers & Brushcutters\nBlowers\nGenerators\nCommercial Equipment\nOther / Not Sure" ),
		'tw3_quote_budget_options'    => array( 'label' => '"Budget Range" dropdown — one option per line', 'type' => 'textarea', 'default' => "Under \$5,000\n\$5,000 – \$15,000\n\$15,000 – \$50,000\n\$50,000+" ),
		'tw3_form_recipient'          => array( 'label' => 'Quote form sends to (email)', 'type' => 'email', 'default' => get_option( 'admin_email' ) ),
	) );
	$wp_customize->add_setting( 'tw3_quote_image', array( 'default' => tw3_text_default( 'tw3_quote_image' ), 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'tw3_quote_image', array(
		'label' => __( 'Quote section photo', 'targetweb3' ), 'section' => 'tw3_sec_quote', 'priority' => 200,
	) ) );

	/* ================= MINI TRUST ROW ================= */
	$wp_customize->add_section( 'tw3_sec_trustrow', array( 'title' => __( 'Mini Trust Row', 'targetweb3' ), 'panel' => 'tw3_panel', 'priority' => 34 ) );
	tw3_register_fields( $wp_customize, 'tw3_sec_trustrow', array(
		'tw3_trust_icon_1' => array( 'label' => 'Item 1 — dashicon name', 'default' => 'plus-alt2' ),
		'tw3_trust_text_1' => array( 'label' => 'Item 1 — text', 'default' => 'Expert Advice' ),
		'tw3_trust_icon_2' => array( 'label' => 'Item 2 — dashicon name', 'default' => 'admin-generic' ),
		'tw3_trust_text_2' => array( 'label' => 'Item 2 — text', 'default' => 'Parts Availability' ),
		'tw3_trust_icon_3' => array( 'label' => 'Item 3 — dashicon name', 'default' => 'arrow-up-alt2' ),
		'tw3_trust_text_3' => array( 'label' => 'Item 3 — text', 'default' => 'Service & Repair' ),
		'tw3_trust_icon_4' => array( 'label' => 'Item 4 — dashicon name', 'default' => 'arrow-right-alt2' ),
		'tw3_trust_text_4' => array( 'label' => 'Item 4 — text', 'default' => 'Delivery Options' ),
	) );

	/* ================= CTA BANNER ================= */
	$wp_customize->add_section( 'tw3_sec_cta', array( 'title' => __( 'CTA Banner', 'targetweb3' ), 'panel' => 'tw3_panel', 'priority' => 36 ) );
	tw3_register_fields( $wp_customize, 'tw3_sec_cta', array(
		'tw3_cta_heading_white' => array( 'label' => 'Heading — line 1 (white)', 'default' => 'Need Equipment Fast?' ),
		'tw3_cta_heading_green' => array( 'label' => 'Heading — line 2 (green)', 'default' => 'Talk to an Expert Today.' ),
		'tw3_cta_btn_text'      => array( 'label' => 'Button text', 'default' => 'Get Assistance' ),
		'tw3_cta_btn_link'      => array( 'label' => 'Button link', 'default' => '#quote', 'type' => 'url' ),
	) );
	$wp_customize->add_setting( 'tw3_cta_image', array( 'default' => tw3_text_default( 'tw3_cta_image' ), 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'tw3_cta_image', array(
		'label' => __( 'Banner background photo', 'targetweb3' ), 'section' => 'tw3_sec_cta', 'priority' => 200,
	) ) );

	/* ================= CONTACT INFO ================= */
	$wp_customize->add_section( 'tw3_sec_contact', array( 'title' => __( 'Contact Info', 'targetweb3' ), 'panel' => 'tw3_panel', 'priority' => 40 ) );
	tw3_register_fields( $wp_customize, 'tw3_sec_contact', array(
		'tw3_contact_address'       => array( 'label' => 'Street address', 'default' => '123 Industrial Way, Your City, ST 12345' ),
		'tw3_contact_phone_display' => array( 'label' => 'Phone number (displayed)', 'default' => '(555) 123-4567' ),
		'tw3_contact_phone_link'    => array( 'label' => 'Phone number (tel: link, digits only)', 'default' => '5551234567' ),
		'tw3_contact_email'         => array( 'label' => 'Contact email', 'type' => 'email', 'default' => 'info@wholegoods.com' ),
		'tw3_hours_weekday'         => array( 'label' => 'Mon–Fri hours', 'default' => '7am – 6pm' ),
		'tw3_hours_saturday'        => array( 'label' => 'Saturday hours', 'default' => '8am – 4pm' ),
		'tw3_hours_sunday'          => array( 'label' => 'Sunday hours', 'default' => 'Closed' ),
	) );

	/* ================= FOOTER ================= */
	$wp_customize->add_section( 'tw3_sec_footer', array( 'title' => __( 'Footer', 'targetweb3' ), 'panel' => 'tw3_panel', 'priority' => 45 ) );
	tw3_register_fields( $wp_customize, 'tw3_sec_footer', array(
		'tw3_footer_tagline'   => array( 'label' => 'Tagline under logo', 'type' => 'textarea', 'default' => 'Premium outdoor power equipment for professionals who demand performance.' ),
		'tw3_footer_copyright' => array( 'label' => 'Copyright line', 'default' => '© ' . date( 'Y' ) . ' Wholegoods. All rights reserved.' ),
		'tw3_social_facebook'  => array( 'label' => 'Facebook URL', 'type' => 'url', 'default' => '' ),
		'tw3_social_instagram' => array( 'label' => 'Instagram URL', 'type' => 'url', 'default' => '' ),
		'tw3_social_youtube'   => array( 'label' => 'YouTube URL', 'type' => 'url', 'default' => '' ),
		'tw3_social_linkedin'  => array( 'label' => 'LinkedIn URL', 'type' => 'url', 'default' => '' ),
	) );
}
add_action( 'customize_register', 'tw3_customize_register' );
