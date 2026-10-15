<?php
/** Single post template. @package TargetWeb3 */
get_header();
?>
<main id="primary" class="tw3-main tw3-container tw3-container--narrow tw3-page-wrap">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class(); ?>>
			<header class="tw3-page-header">
				<h1><?php the_title(); ?></h1>
				<p class="tw3-post-meta"><?php echo esc_html( get_the_date() ); ?> · <?php the_author(); ?></p>
			</header>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="tw3-post-thumb"><?php the_post_thumbnail( 'tw3-wide' ); ?></div>
			<?php endif; ?>
			<div class="tw3-page-content"><?php the_content(); ?></div>
		</article>
		<?php if ( comments_open() || get_comments_number() ) comments_template(); ?>
	<?php endwhile; ?>
</main>
<?php get_sidebar(); get_footer(); ?>
