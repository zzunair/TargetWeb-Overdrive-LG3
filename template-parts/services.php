<?php
/** Services grid — dark section. @package TargetWeb3 */
$items = tw3_get_repeater( 'tw3_services_repeater' );
if ( empty( $items ) ) return;
?>
<section class="tw3-section tw3-section--dark" id="services">
	<div class="tw3-container">
		<div class="tw3-section__head">
			<span class="tw3-eyebrow tw3-eyebrow--ondark"><?php echo esc_html( tw3_opt( 'tw3_services_eyebrow' ) ); ?></span>
			<h2 class="tw3-heading--ondark"><?php echo esc_html( tw3_opt( 'tw3_services_heading' ) ); ?></h2>
			<p class="tw3-sub--ondark"><?php echo esc_html( tw3_opt( 'tw3_services_sub' ) ); ?></p>
		</div>

		<div class="tw3-services-grid">
			<?php foreach ( $items as $item ) :
				$title = $item['title'] ?? '';
				if ( '' === $title ) continue;
				$icon = $item['icon'] ?? '';
				?>
				<div class="tw3-service-card">
					<?php if ( $icon ) : ?>
						<span class="tw3-service-card__icon"><span class="dashicons dashicons-<?php echo esc_attr( $icon ); ?>"></span></span>
					<?php endif; ?>
					<h3><?php echo esc_html( $title ); ?></h3>
					<p><?php echo esc_html( $item['description'] ?? '' ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
