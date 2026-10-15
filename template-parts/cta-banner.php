<?php
/** CTA banner — full-bleed photo band. @package TargetWeb3 */
$img = tw3_opt( 'tw3_cta_image' );
?>
<section class="tw3-cta-banner">
	<?php if ( $img ) : ?>
		<img class="tw3-cta-banner__img" src="<?php echo esc_url( $img ); ?>" alt="">
	<?php endif; ?>
	<span class="tw3-cta-banner__scrim"></span>
	<div class="tw3-container tw3-cta-banner__content">
		<h2>
			<span class="tw3-heading--ondark"><?php echo esc_html( tw3_opt( 'tw3_cta_heading_white' ) ); ?></span>
			<span class="tw3-hero__heading-green"><?php echo esc_html( tw3_opt( 'tw3_cta_heading_green' ) ); ?></span>
		</h2>
		<a class="tw3-btn tw3-btn--primary tw3-btn--lg" href="<?php echo esc_url( tw3_opt( 'tw3_cta_btn_link' ) ); ?>">
			<?php echo esc_html( tw3_opt( 'tw3_cta_btn_text' ) ); ?>
		</a>
	</div>
</section>
