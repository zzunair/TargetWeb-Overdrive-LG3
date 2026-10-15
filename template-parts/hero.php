<?php
/** Hero section — full-bleed photo, condensed bold type. @package TargetWeb3 */
$hero_img = tw3_opt( 'tw3_hero_image' );
?>
<section class="tw3-hero">
	<div class="tw3-hero__media">
		<?php if ( $hero_img ) : ?>
			<img src="<?php echo esc_url( $hero_img ); ?>" alt="">
		<?php endif; ?>
		<div class="tw3-hero__overlay"></div>
	</div>

	<div class="tw3-container tw3-hero__content">
		<span class="tw3-eyebrow tw3-eyebrow--ondark"><?php echo esc_html( tw3_opt( 'tw3_hero_eyebrow' ) ); ?></span>
		<h1 class="tw3-hero__heading">
			<span class="tw3-hero__heading-white"><?php echo esc_html( tw3_opt( 'tw3_hero_heading_line1' ) ); ?></span>
			<span class="tw3-hero__heading-white"><?php echo esc_html( tw3_opt( 'tw3_hero_heading_line2' ) ); ?></span>
			<span class="tw3-hero__heading-green"><?php echo esc_html( tw3_opt( 'tw3_hero_heading_green' ) ); ?></span>
		</h1>
		<p class="tw3-hero__sub"><?php echo esc_html( tw3_opt( 'tw3_hero_subtext' ) ); ?></p>
		<div class="tw3-hero__actions">
			<a class="tw3-btn tw3-btn--primary tw3-btn--lg" href="<?php echo esc_url( tw3_opt( 'tw3_hero_btn1_link' ) ); ?>">
				<?php echo esc_html( tw3_opt( 'tw3_hero_btn1_text' ) ); ?>
			</a>
			<a class="tw3-btn tw3-btn--outline-ondark tw3-btn--lg" href="<?php echo esc_url( tw3_opt( 'tw3_hero_btn2_link' ) ); ?>">
				<?php echo esc_html( tw3_opt( 'tw3_hero_btn2_text' ) ); ?>
			</a>
		</div>
	</div>

	<div class="tw3-hero__scroll">
		<span><?php echo esc_html( tw3_opt( 'tw3_hero_scroll_text' ) ); ?></span>
		<span class="tw3-hero__scroll-line"></span>
	</div>
</section>
