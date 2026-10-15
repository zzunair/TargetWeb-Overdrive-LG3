<?php
/**
 * Footer
 *
 * @package TargetWeb3
 */
?>
	<footer class="tw3-footer">
		<div class="tw3-container tw3-footer__grid">
			<div class="tw3-footer__brand">
				<?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
					<div class="tw3-header__logo-fallback">
						<span class="tw3-logo-bullet" aria-hidden="true"></span>
						<span class="tw3-logo-text"><?php bloginfo( 'name' ); ?></span>
					</div>
				<?php endif; ?>
				<p class="tw3-footer__tagline"><?php echo esc_html( tw3_opt( 'tw3_footer_tagline' ) ); ?></p>
				<div class="tw3-social-row">
					<?php tw3_social_icons(); ?>
				</div>
			</div>

			<div class="tw3-footer__col">
				<h4><?php _e( 'Equipment', 'targetweb3' ); ?></h4>
				<?php wp_nav_menu( array( 'theme_location' => 'footer-equipment', 'container' => false, 'menu_class' => 'tw3-footer__list', 'fallback_cb' => false ) ); ?>
			</div>

			<div class="tw3-footer__col">
				<h4><?php _e( 'Contact Info', 'targetweb3' ); ?></h4>
				<p><?php echo esc_html( tw3_opt( 'tw3_contact_address' ) ); ?></p>
				<p><a href="tel:<?php echo esc_attr( tw3_opt( 'tw3_contact_phone_link' ) ); ?>"><?php echo esc_html( tw3_opt( 'tw3_contact_phone_display' ) ); ?></a></p>
				<p><a href="mailto:<?php echo esc_attr( tw3_opt( 'tw3_contact_email' ) ); ?>"><?php echo esc_html( tw3_opt( 'tw3_contact_email' ) ); ?></a></p>
			</div>

			<div class="tw3-footer__col">
				<h4><?php _e( 'Hours', 'targetweb3' ); ?></h4>
				<p><?php _e( 'Mon – Fri:', 'targetweb3' ); ?> <?php echo esc_html( tw3_opt( 'tw3_hours_weekday' ) ); ?></p>
				<p><?php _e( 'Sat:', 'targetweb3' ); ?> <?php echo esc_html( tw3_opt( 'tw3_hours_saturday' ) ); ?></p>
				<p><?php _e( 'Sun:', 'targetweb3' ); ?> <?php echo esc_html( tw3_opt( 'tw3_hours_sunday' ) ); ?></p>
			</div>
		</div>

		<div class="tw3-container tw3-footer__bottom">
			<p><?php echo esc_html( tw3_opt( 'tw3_footer_copyright' ) ); ?></p>
			<div class="tw3-footer__legal">
				<a href="#"><?php _e( 'Privacy', 'targetweb3' ); ?></a>
				<a href="#"><?php _e( 'Terms', 'targetweb3' ); ?></a>
			</div>
		</div>
	</footer>

	<!-- Shared category popup modal — one instance, filled by JS on click -->
	<div class="tw3-modal" id="tw3-category-modal" aria-hidden="true">
		<div class="tw3-modal__overlay" data-tw3-modal-close></div>
		<div class="tw3-modal__panel" role="dialog" aria-modal="true" aria-labelledby="tw3-modal-title">
			<button class="tw3-modal__close" data-tw3-modal-close aria-label="<?php esc_attr_e( 'Close', 'targetweb3' ); ?>">
				<span class="dashicons dashicons-no-alt"></span>
			</button>
			<div class="tw3-modal__media">
				<img src="" alt="" id="tw3-modal-image">
			</div>
			<div class="tw3-modal__body">
				<h3 id="tw3-modal-title"></h3>
				<p id="tw3-modal-description"></p>
				<a class="tw3-btn tw3-btn--primary" id="tw3-modal-cta" href="#quote"></a>
			</div>
		</div>
	</div>

<?php wp_footer(); ?>
</body>
</html>
