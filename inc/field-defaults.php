<?php
/**
 * Central default values for every plain text/textarea/url/number
 * Customizer field. Read by BOTH inc/customizer.php (Customizer UI) and
 * tw3_opt() (every front-end template), so the two can never drift apart
 * and a fresh activation is fully populated everywhere — see the same
 * lesson learned and documented in this file.
 *
 * @package TargetWeb3
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function tw3_text_defaults() {
	static $defaults = null;
	if ( null !== $defaults ) return $defaults;

	$defaults = array(
		// Header
		'tw3_header_cta_text' => 'Get a Quote',
		'tw3_header_cta_link' => '#quote',

		// Hero
		'tw3_hero_eyebrow'       => 'Outdoor Power Equipment',
		'tw3_hero_heading_line1' => 'Powerful',
		'tw3_hero_heading_line2' => 'Equipment.',
		'tw3_hero_heading_green' => 'Built to Perform.',
		'tw3_hero_subtext'       => 'High-quality outdoor power equipment from trusted brands. Reliable, durable, and ready to work.',
		'tw3_hero_btn1_text'     => 'Get a Quote',
		'tw3_hero_btn1_link'     => '#quote',
		'tw3_hero_btn2_text'     => 'Browse Equipment',
		'tw3_hero_btn2_link'     => '#equipment',
		'tw3_hero_scroll_text'   => 'Scroll',

		// Section titles
		'tw3_cat_eyebrow'   => 'Categories',
		'tw3_cat_heading'   => 'Explore Our Equipment',
		'tw3_cat_sub'       => 'Browse our full lineup of commercial-grade outdoor power equipment.',
		'tw3_brand_heading' => 'Trusted Brands. Proven Performance.',
		'tw3_whyus_eyebrow' => 'Why Us',
		'tw3_whyus_heading' => 'Why Choose Wholegoods?',
		'tw3_whyus_sub'     => 'We deliver expert guidance, premium equipment, and lasting support.',
		'tw3_quote_eyebrow' => 'Lead Generation',
		'tw3_quote_heading' => 'Get a Quote Today',
		'tw3_quote_sub'     => 'Tell us what you need and our team will get back to you with the best solution.',
		'tw3_cta_heading_white' => 'Need Equipment Fast?',
		'tw3_cta_heading_green' => 'Talk to an Expert Today.',
		'tw3_cta_btn_text'      => 'Get Assistance',
		'tw3_cta_btn_link'      => '#quote',

		// Mini trust row (4 items under the quote form)
		'tw3_trust_icon_1' => 'plus-alt2',       'tw3_trust_text_1' => 'Expert Advice',
		'tw3_trust_icon_2' => 'admin-generic',   'tw3_trust_text_2' => 'Parts Availability',
		'tw3_trust_icon_3' => 'arrow-up-alt2',   'tw3_trust_text_3' => 'Service & Repair',
		'tw3_trust_icon_4' => 'arrow-right-alt2','tw3_trust_text_4' => 'Delivery Options',

		// Quote form select options — one option per line
		'tw3_quote_equipment_options' => "Lawn Mowers\nChainsaws\nTrimmers & Brushcutters\nBlowers\nGenerators\nCommercial Equipment\nOther / Not Sure",
		'tw3_quote_budget_options'    => "Under \$5,000\n\$5,000 – \$15,000\n\$15,000 – \$50,000\n\$50,000+",
		'tw3_form_recipient'          => get_option( 'admin_email' ),

		// Contact
		'tw3_contact_address'     => '123 Industrial Way, Your City, ST 12345',
		'tw3_contact_phone_display' => '(555) 123-4567',
		'tw3_contact_phone_link'  => '5551234567',
		'tw3_contact_email'       => 'info@wholegoods.com',
		'tw3_hours_weekday'       => '7am – 6pm',
		'tw3_hours_saturday'      => '8am – 4pm',
		'tw3_hours_sunday'        => 'Closed',

		// Footer
		'tw3_footer_tagline'   => 'Premium outdoor power equipment for professionals who demand performance.',
		'tw3_footer_copyright' => '© ' . date( 'Y' ) . ' Wholegoods. All rights reserved.',
		'tw3_social_facebook'  => '',
		'tw3_social_instagram' => '',
		'tw3_social_youtube'   => '',
		'tw3_social_linkedin'  => '',

		// Images
		'tw3_hero_image' => TW3_URI . '/assets/images/scenes/hero.svg',
		'tw3_cta_image'  => TW3_URI . '/assets/images/scenes/cta-banner.svg',
		'tw3_quote_image'=> TW3_URI . '/assets/images/scenes/quote.svg',

		// Colors
		'tw3_color_dark'          => '#0D110D',
		'tw3_color_dark_alt'      => '#141810',
		'tw3_color_light'         => '#F4F5F1',
		'tw3_color_light_alt'     => '#E9EBE4',
		'tw3_color_green'         => '#2F7D46',
		'tw3_color_green_bright'  => '#4CAF50',
		'tw3_color_text_dark'     => '#151A13',
		'tw3_color_text_onlight_muted' => '#5B6058',
		'tw3_color_text_ondark_muted'  => '#9CA39A',
		'tw3_color_border_light'  => '#DEE1D7',
	);

	return $defaults;
}

function tw3_text_default( $key ) {
	$defaults = tw3_text_defaults();
	return isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
}
