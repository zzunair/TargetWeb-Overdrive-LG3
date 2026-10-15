<?php
/** Default page template. @package TargetWeb3 */
get_header();
?>
<main id="primary" class="tw3-main tw3-container tw3-container--narrow tw3-page-wrap">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class(); ?>>
			<header class="tw3-page-header"><h1><?php the_title(); ?></h1></header>
			<div class="tw3-page-content"><?php the_content(); ?></div>
		</article>
	<?php endwhile; ?>
</main>
<?php get_footer(); ?>
