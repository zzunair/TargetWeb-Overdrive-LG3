<?php
/** Visit us — showroom address, phone, email, and hours. @package TargetWeb3 */
$address = tw3_opt( 'tw3_contact_address' );
$phone   = tw3_opt( 'tw3_contact_phone_display' );
$tel     = preg_replace( '/[^0-9+]/', '', tw3_opt( 'tw3_contact_phone_link' ) );
$email   = tw3_opt( 'tw3_contact_email' );
$map     = tw3_opt( 'tw3_visit_map_link' );
?>
<section class="tw3-section tw3-section--light" id="visit">
	<div class="tw3-container tw3-visit">
		<div class="tw3-visit__copy">
			<span class="tw3-eyebrow"><?php echo esc_html( tw3_opt( 'tw3_visit_eyebrow' ) ); ?></span>
			<h2><?php echo esc_html( tw3_opt( 'tw3_visit_heading' ) ); ?></h2>
			<p><?php echo esc_html( tw3_opt( 'tw3_visit_sub' ) ); ?></p>
			<?php if ( $map ) : ?>
				<a class="tw3-btn tw3-btn--primary" href="<?php echo esc_url( $map ); ?>" target="_blank" rel="noopener noreferrer"><?php _e( 'Get Directions', 'targetweb3' ); ?></a>
			<?php endif; ?>
		</div>

		<div class="tw3-visit__cards">
			<?php if ( $address ) : ?>
				<div class="tw3-visit-card">
					<span class="tw3-visit-card__icon dashicons dashicons-location-alt"></span>
					<h3><?php _e( 'Showroom', 'targetweb3' ); ?></h3>
					<p><?php echo esc_html( $address ); ?></p>
				</div>
			<?php endif; ?>
			<div class="tw3-visit-card">
				<span class="tw3-visit-card__icon dashicons dashicons-clock"></span>
				<h3><?php _e( 'Hours', 'targetweb3' ); ?></h3>
				<p><?php _e( 'Mon – Fri:', 'targetweb3' ); ?> <?php echo esc_html( tw3_opt( 'tw3_hours_weekday' ) ); ?></p>
				<p><?php _e( 'Sat:', 'targetweb3' ); ?> <?php echo esc_html( tw3_opt( 'tw3_hours_saturday' ) ); ?></p>
				<p><?php _e( 'Sun:', 'targetweb3' ); ?> <?php echo esc_html( tw3_opt( 'tw3_hours_sunday' ) ); ?></p>
			</div>
			<?php if ( $phone ) : ?>
				<div class="tw3-visit-card">
					<span class="tw3-visit-card__icon dashicons dashicons-phone"></span>
					<h3><?php _e( 'Call', 'targetweb3' ); ?></h3>
					<a href="tel:<?php echo esc_attr( $tel ); ?>"><?php echo esc_html( $phone ); ?></a>
				</div>
			<?php endif; ?>
			<?php if ( $email ) : ?>
				<div class="tw3-visit-card">
					<span class="tw3-visit-card__icon dashicons dashicons-email"></span>
					<h3><?php _e( 'Email', 'targetweb3' ); ?></h3>
					<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
