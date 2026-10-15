<?php
/** Mini trust row — 4 items under the quote form. @package TargetWeb3 */
?>
<div class="tw3-trust-row">
	<div class="tw3-container tw3-trust-row__inner">
		<?php for ( $i = 1; $i <= 4; $i++ ) :
			$icon = tw3_opt( "tw3_trust_icon_$i" );
			$text = tw3_opt( "tw3_trust_text_$i" );
			if ( empty( $text ) ) continue;
			?>
			<div class="tw3-trust-row__item">
				<?php if ( $icon ) : ?>
					<span class="tw3-trust-row__icon"><span class="dashicons dashicons-<?php echo esc_attr( $icon ); ?>"></span></span>
				<?php endif; ?>
				<span><?php echo esc_html( $text ); ?></span>
			</div>
		<?php endfor; ?>
	</div>
</div>
