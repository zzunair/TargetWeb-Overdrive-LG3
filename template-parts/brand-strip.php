<?php
/** Brand wall — dark strip of trusted brand names/logos. @package TargetWeb3 */
$items = tw3_get_repeater( 'tw3_brands_repeater' );
if ( empty( $items ) ) return;
?>
<section class="tw3-brand-strip" id="brands">
	<div class="tw3-container">
		<h2 class="tw3-brand-strip__heading"><?php echo esc_html( tw3_opt( 'tw3_brand_heading' ) ); ?></h2>
		<div class="tw3-brand-strip__row">
			<?php foreach ( $items as $item ) :
				$name = $item['name'] ?? '';
				if ( '' === $name ) continue;
				$logo = $item['logo'] ?? '';
				?>
				<div class="tw3-brand-strip__item">
					<?php if ( $logo ) : ?>
						<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $name ); ?>">
					<?php else : ?>
						<span><?php echo esc_html( $name ); ?></span>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
