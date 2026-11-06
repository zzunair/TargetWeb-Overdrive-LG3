<?php
/** Customer reviews — light section. @package TargetWeb3 */
$items = tw3_get_repeater( 'tw3_testimonials_repeater' );
if ( empty( $items ) ) return;
?>
<section class="tw3-section tw3-section--light" id="reviews">
	<div class="tw3-container">
		<div class="tw3-section__head">
			<span class="tw3-eyebrow"><?php echo esc_html( tw3_opt( 'tw3_testimonials_eyebrow' ) ); ?></span>
			<h2><?php echo esc_html( tw3_opt( 'tw3_testimonials_heading' ) ); ?></h2>
			<p><?php echo esc_html( tw3_opt( 'tw3_testimonials_sub' ) ); ?></p>
		</div>

		<div class="tw3-testimonials-grid">
			<?php foreach ( $items as $item ) :
				$quote = $item['quote'] ?? '';
				if ( '' === $quote ) continue;
				$rating = max( 1, min( 5, (int) ( $item['rating'] ?? 5 ) ) );
				?>
				<figure class="tw3-testimonial">
					<span class="tw3-testimonial__stars" aria-label="<?php echo esc_attr( sprintf( __( '%d out of 5 stars', 'targetweb3' ), $rating ) ); ?>"><?php echo esc_html( str_repeat( '★', $rating ) ); ?></span>
					<blockquote><?php echo esc_html( $quote ); ?></blockquote>
					<figcaption>
						<strong><?php echo esc_html( $item['name'] ?? '' ); ?></strong>
						<?php if ( ! empty( $item['role'] ) ) : ?>
							<span><?php echo esc_html( $item['role'] ); ?></span>
						<?php endif; ?>
					</figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>
