<?php
/**
 * Handles the front-end "Request Quote" form submission.
 *
 * @package TargetWeb3
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * The TargetWeb CRM plugin owns the quote card when it is enabled.
 */
function tw3_crm_ready() {
	if ( ! class_exists( 'TW_CRM_Frontend' ) || ! class_exists( 'TW_CRM_Settings' ) ) {
		return false;
	}
	$settings = TW_CRM_Settings::get_settings();
	return ! empty( $settings['enabled'] );
}

function tw3_quote_redirect( $status ) {
	$url = remove_query_arg( array( 'tw3_quote' ) );
	$url = add_query_arg( 'tw3_quote', $status, $url );
	wp_safe_redirect( $url . '#quote' );
	exit;
}

function tw3_quote_limited() {
	$ip    = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$key   = 'tw3_quote_' . md5( $ip );
	$count = (int) get_transient( $key );
	if ( $count >= 8 ) {
		return true;
	}
	set_transient( $key, $count + 1, HOUR_IN_SECONDS );
	return false;
}

function tw3_handle_quote_form() {
	if ( ! isset( $_POST['tw3_quote_submit'] ) ) return;
	if ( ! isset( $_POST['tw3_quote_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tw3_quote_nonce'] ) ), 'tw3_quote_form' ) ) {
		tw3_quote_redirect( 'error' );
	}

	if ( ! empty( $_POST['tw3_website'] ) ) {
		tw3_quote_redirect( 'sent' );
	}
	if ( tw3_quote_limited() ) {
		tw3_quote_redirect( 'limit' );
	}

	$name      = isset( $_POST['tw3_name'] ) ? sanitize_text_field( wp_unslash( $_POST['tw3_name'] ) ) : '';
	$raw_email = isset( $_POST['tw3_email'] ) ? sanitize_text_field( wp_unslash( $_POST['tw3_email'] ) ) : '';
	$email     = sanitize_email( $raw_email );
	$phone     = isset( $_POST['tw3_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['tw3_phone'] ) ) : '';
	$equip     = isset( $_POST['tw3_equipment'] ) ? sanitize_text_field( wp_unslash( $_POST['tw3_equipment'] ) ) : '';
	$budget    = isset( $_POST['tw3_budget'] ) ? sanitize_text_field( wp_unslash( $_POST['tw3_budget'] ) ) : '';
	$message   = isset( $_POST['tw3_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['tw3_message'] ) ) : '';

	if ( '' === $name ) {
		tw3_quote_redirect( 'error' );
	}
	if ( '' === trim( $raw_email ) || ! is_email( $raw_email ) || '' === $email ) {
		tw3_quote_redirect( 'email' );
	}

	$to      = tw3_opt( 'tw3_form_recipient', get_option( 'admin_email' ) );
	$subject = sprintf( __( 'New Quote Request — %s', 'targetweb3' ), $name );
	$body    = "New quote request from the website:\n\n"
		. "Name: {$name}\n"
		. "Email: {$email}\n"
		. "Phone: {$phone}\n"
		. "Equipment Needed: {$equip}\n"
		. "Budget Range: {$budget}\n\n"
		. "Additional Details:\n{$message}\n";

	$headers = array( "Reply-To: {$name} <{$email}>" );
	wp_mail( $to, $subject, $body, $headers );

	tw3_quote_redirect( 'sent' );
}
add_action( 'template_redirect', 'tw3_handle_quote_form' );
