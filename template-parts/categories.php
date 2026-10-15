<?php
/** Equipment categories grid — each card opens a popup modal on click. @package TargetWeb3 */
$items = tw3_get_repeater( 'tw3_categories_repeater' );
if ( empty( $items ) ) return;
?>
<section class="tw3-section tw3-section--dark" id="equipment">
	<div class="tw3-container">
		<div class="tw3-section__head">
			<span class="tw3-eyebrow tw3-eyebrow--ondark"><?php echo esc_html( tw3_opt( 'tw3_cat_eyebrow' ) ); ?></span>
			<h2 class="tw3-heading--ondark"><?php echo esc_html( tw3_opt( 'tw3_cat_heading' ) ); ?></h2>
			<p class="tw3-sub--ondark"><?php echo esc_html( tw3_opt( 'tw3_cat_sub' ) ); ?></p>
		</div>

		<div class="tw3-category-grid">
			<?php foreach ( $items as $index => $item ) :
				$title = $item['title'] ?? '';
				if ( '' === $title ) continue;
				$icon  = $item['icon'] ?? '';
				$image = $item['image'] ?? '';
				?>
				<button type="button" class="tw3-category-card" data-tw3-cat-index="<?php echo esc_attr( $index ); ?>">
					<?php if ( $image ) : ?>
						<img class="tw3-category-card__img" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>">
					<?php endif; ?>
					<span class="tw3-category-card__scrim"></span>
					<?php if ( $icon ) : ?>
						<span class="tw3-category-card__icon"><span class="dashicons dashicons-<?php echo esc_attr( $icon ); ?>"></span></span>
					<?php endif; ?>
					<span class="tw3-category-card__footer">
						<span class="tw3-category-card__title"><?php echo esc_html( $title ); ?></span>
						<span class="tw3-category-card__explore"><?php _e( 'Explore', 'targetweb3' ); ?> <span class="dashicons dashicons-arrow-right-alt"></span></span>
					</span>
				</button>
			<?php endforeach; ?>
		</div>
	</div>
</section>
