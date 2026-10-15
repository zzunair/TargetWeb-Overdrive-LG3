<?php
/** 404 template. @package TargetWeb3 */
get_header();
?>
<main id="primary" class="tw3-main tw3-container tw3-container--narrow tw3-404">
	<span class="tw3-eyebrow">404</span>
	<h1><?php _e( 'This page took a detour.', 'targetweb3' ); ?></h1>
	<p><?php _e( "The page you're looking for doesn't exist or has moved.", 'targetweb3' ); ?></p>
	<a class="tw3-btn tw3-btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e( 'Back to Home', 'targetweb3' ); ?></a>
</main>
<?php get_footer(); ?>
