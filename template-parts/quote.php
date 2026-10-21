<?php
/** Quote section — image/overlay copy on the left, dark form on the right. @package TargetWeb3 */
$img = tw3_opt( 'tw3_quote_image' );
$quote_state = isset( $_GET['tw3_quote'] ) ? sanitize_key( wp_unslash( $_GET['tw3_quote'] ) ) : '';
$sent        = ( 'sent' === $quote_state );
$quote_error = '';
if ( 'email' === $quote_state ) {
	$quote_error = __( 'Please enter a valid email address.', 'targetweb3' );
} elseif ( 'error' === $quote_state ) {
	$quote_error = __( 'Please enter your name and a valid email address.', 'targetweb3' );
} elseif ( 'limit' === $quote_state ) {
	$quote_error = __( 'Please wait a while before sending another request.', 'targetweb3' );
}
$equipment_options = array_filter( array_map( 'trim', explode( "\n", tw3_opt( 'tw3_quote_equipment_options' ) ) ) );
$budget_options    = array_filter( array_map( 'trim', explode( "\n", tw3_opt( 'tw3_quote_budget_options' ) ) ) );
?>
<section class="tw3-quote" id="quote">
	<div class="tw3-quote__media">
		<?php if ( $img ) : ?>
			<img src="<?php echo esc_url( $img ); ?>" alt="">
		<?php endif; ?>
		<span class="tw3-quote__scrim"></span>
		<div class="tw3-quote__media-copy">
			<span class="tw3-eyebrow tw3-eyebrow--ondark"><?php echo esc_html( tw3_opt( 'tw3_quote_eyebrow' ) ); ?></span>
			<h2 class="tw3-heading--ondark"><?php echo esc_html( tw3_opt( 'tw3_quote_heading' ) ); ?></h2>
			<p class="tw3-sub--ondark"><?php echo esc_html( tw3_opt( 'tw3_quote_sub' ) ); ?></p>
		</div>
	</div>

	<div class="tw3-quote__form-wrap">
		<h3><?php _e( 'Request a Quote', 'targetweb3' ); ?></h3>

		<?php if ( $sent ) : ?>
			<div class="tw3-form-success">
				<span class="dashicons dashicons-yes-alt"></span>
				<p><?php _e( "Thanks — we've got your request and will follow up shortly.", 'targetweb3' ); ?></p>
			</div>
		<?php elseif ( tw3_crm_ready() ) : ?>
			<?php do_action( 'tw_crm_render_form' ); ?>
		<?php else : ?>
		<form class="tw3-quote-form" method="post" action="<?php echo esc_url( home_url( '/' ) ); ?>#quote">
			<?php wp_nonce_field( 'tw3_quote_form', 'tw3_quote_nonce' ); ?>
			<input type="hidden" name="tw3_quote_submit" value="1">
			<div class="tw3-hp" aria-hidden="true"><label><?php esc_html_e( 'Website', 'targetweb3' ); ?><input type="text" name="tw3_website" tabindex="-1" autocomplete="off"></label></div>
			<?php if ( $quote_error ) : ?>
				<p class="tw3-form-error" role="alert"><?php echo esc_html( $quote_error ); ?></p>
			<?php endif; ?>

			<div class="tw3-form-row tw3-form-row--split">
				<div class="tw3-form-field">
					<label><?php _e( 'Full Name', 'targetweb3' ); ?></label>
					<input type="text" name="tw3_name" required>
				</div>
				<div class="tw3-form-field">
					<label><?php _e( 'Email Address', 'targetweb3' ); ?></label>
					<input type="email" name="tw3_email" required>
				</div>
			</div>

			<div class="tw3-form-row tw3-form-row--split">
				<div class="tw3-form-field">
					<label><?php _e( 'Phone Number', 'targetweb3' ); ?></label>
					<input type="tel" name="tw3_phone">
				</div>
				<div class="tw3-form-field">
					<label><?php _e( 'Equipment Needed', 'targetweb3' ); ?></label>
					<select name="tw3_equipment">
						<option value=""><?php _e( 'Select', 'targetweb3' ); ?></option>
						<?php foreach ( $equipment_options as $opt ) : ?>
							<option value="<?php echo esc_attr( $opt ); ?>"><?php echo esc_html( $opt ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="tw3-form-field">
				<label><?php _e( 'Budget Range', 'targetweb3' ); ?></label>
				<select name="tw3_budget">
					<option value=""><?php _e( 'Select', 'targetweb3' ); ?></option>
					<?php foreach ( $budget_options as $opt ) : ?>
						<option value="<?php echo esc_attr( $opt ); ?>"><?php echo esc_html( $opt ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="tw3-form-field">
				<label><?php _e( 'Additional Details', 'targetweb3' ); ?></label>
				<textarea name="tw3_message" rows="3"></textarea>
			</div>

			<button type="submit" class="tw3-btn tw3-btn--primary tw3-btn--block">
				<?php _e( 'Request Quote', 'targetweb3' ); ?>
			</button>
		</form>
		<?php endif; ?>
	</div>
</section>
