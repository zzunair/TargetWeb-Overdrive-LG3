<?php
/**
 * Handles the front-end "Request Quote" form submission.
 *
 * @package TargetWeb3
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function tw3_handle_quote_form() {
	if ( ! isset( $_POST['tw3_quote_submit'] ) ) return;
	if ( ! isset( $_POST['tw3_quote_nonce'] ) || ! wp_verify_nonce( $_POST['tw3_quote_nonce'], 'tw3_quote_form' ) ) return;

	$name    = isset( $_POST['tw3_name'] ) ? sanitize_text_field( wp_unslash( $_POST['tw3_name'] ) ) : '';
	$email   = isset( $_POST['tw3_email'] ) ? sanitize_email( wp_unslash( $_POST['tw3_email'] ) ) : '';
	$phone   = isset( $_POST['tw3_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['tw3_phone'] ) ) : '';
	$equip   = isset( $_POST['tw3_equipment'] ) ? sanitize_text_field( wp_unslash( $_POST['tw3_equipment'] ) ) : '';
	$budget  = isset( $_POST['tw3_budget'] ) ? sanitize_text_field( wp_unslash( $_POST['tw3_budget'] ) ) : '';
	$message = isset( $_POST['tw3_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['tw3_message'] ) ) : '';

	if ( empty( $name ) || empty( $email ) ) return;

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

	wp_safe_redirect( add_query_arg( 'tw3_quote', 'sent', remove_query_arg( array( 'tw3_quote' ) ) ) . '#quote' );
	exit;
}
add_action( 'template_redirect', 'tw3_handle_quote_form' );
