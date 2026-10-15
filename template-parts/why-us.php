<?php
/** Why Choose Us feature tiles — light section. @package TargetWeb3 */
$items = tw3_get_repeater( 'tw3_features_repeater' );
if ( empty( $items ) ) return;
?>
<section class="tw3-section tw3-section--light">
	<div class="tw3-container">
		<div class="tw3-section__head">
			<span class="tw3-eyebrow"><?php echo esc_html( tw3_opt( 'tw3_whyus_eyebrow' ) ); ?></span>
			<h2><?php echo esc_html( tw3_opt( 'tw3_whyus_heading' ) ); ?></h2>
			<p><?php echo esc_html( tw3_opt( 'tw3_whyus_sub' ) ); ?></p>
		</div>

		<div class="tw3-features-grid">
			<?php foreach ( $items as $item ) :
				$title = $item['title'] ?? '';
				if ( '' === $title ) continue;
				$icon = $item['icon'] ?? '';
				?>
				<div class="tw3-feature-tile">
					<?php if ( $icon ) : ?>
						<span class="tw3-feature-tile__icon"><span class="dashicons dashicons-<?php echo esc_attr( $icon ); ?>"></span></span>
					<?php endif; ?>
					<h3><?php echo esc_html( $title ); ?></h3>
					<p><?php echo esc_html( $item['description'] ?? '' ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
