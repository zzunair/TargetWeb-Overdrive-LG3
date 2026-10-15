<?php
/**
 * Header
 *
 * @package TargetWeb3
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary"><?php _e( 'Skip to content', 'targetweb3' ); ?></a>

<header class="tw3-header">
	<div class="tw3-container tw3-header__inner">

		<div class="tw3-header__brand">
			<?php if ( has_custom_logo() ) : ?>
				<div class="tw3-header__logo"><?php the_custom_logo(); ?></div>
			<?php else : ?>
				<a class="tw3-header__logo-fallback" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<span class="tw3-logo-bullet" aria-hidden="true"></span>
					<span class="tw3-logo-text"><?php bloginfo( 'name' ); ?></span>
				</a>
			<?php endif; ?>
		</div>

		<nav class="tw3-header__nav" aria-label="<?php esc_attr_e( 'Primary Menu', 'targetweb3' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'tw3-nav-menu',
				'fallback_cb'    => 'tw3_default_menu_fallback',
			) );
			?>
		</nav>

		<div class="tw3-header__actions">
			<a class="tw3-btn tw3-btn--primary tw3-btn--sm" href="<?php echo esc_url( tw3_opt( 'tw3_header_cta_link' ) ); ?>">
				<?php echo esc_html( tw3_opt( 'tw3_header_cta_text' ) ); ?>
			</a>
		</div>

		<button class="tw3-mobile-toggle" aria-expanded="false" aria-controls="tw3-mobile-menu" aria-label="<?php esc_attr_e( 'Toggle menu', 'targetweb3' ); ?>">
			<span></span><span></span><span></span>
		</button>
	</div>

	<div id="tw3-mobile-menu" class="tw3-mobile-menu">
		<?php
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => false,
			'menu_class'     => 'tw3-mobile-menu__list',
			'fallback_cb'    => 'tw3_default_menu_fallback',
		) );
		?>
		<a class="tw3-btn tw3-btn--primary" href="<?php echo esc_url( tw3_opt( 'tw3_header_cta_link' ) ); ?>">
			<?php echo esc_html( tw3_opt( 'tw3_header_cta_text' ) ); ?>
		</a>
	</div>
</header>

<?php
function tw3_default_menu_fallback() {
	echo '<ul class="tw3-nav-menu"><li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'targetweb3' ) . '</a></li></ul>';
}
