<?php
/** FAQ accordion — dark section. @package TargetWeb3 */
$items = tw3_get_repeater( 'tw3_faqs_repeater' );
if ( empty( $items ) ) return;
?>
<section class="tw3-section tw3-section--dark" id="faq">
	<div class="tw3-container tw3-container--narrow">
		<div class="tw3-section__head">
			<span class="tw3-eyebrow tw3-eyebrow--ondark"><?php echo esc_html( tw3_opt( 'tw3_faq_eyebrow' ) ); ?></span>
			<h2 class="tw3-heading--ondark"><?php echo esc_html( tw3_opt( 'tw3_faq_heading' ) ); ?></h2>
			<p class="tw3-sub--ondark"><?php echo esc_html( tw3_opt( 'tw3_faq_sub' ) ); ?></p>
		</div>

		<div class="tw3-faq-list">
			<?php foreach ( $items as $index => $item ) :
				$question = $item['question'] ?? '';
				if ( '' === $question ) continue;
				?>
				<details class="tw3-faq-item"<?php echo 0 === $index ? ' open' : ''; ?>>
					<summary><?php echo esc_html( $question ); ?></summary>
					<p><?php echo esc_html( $item['answer'] ?? '' ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
