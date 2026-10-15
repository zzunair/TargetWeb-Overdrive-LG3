<?php
/**
 * Default fallback template — standard blog loop.
 * @package TargetWeb3
 */
get_header();
?>
<main id="primary" class="tw3-main tw3-container tw3-container--narrow tw3-blog-wrap">
	<?php if ( have_posts() ) : ?>
		<div class="tw3-blog-grid">
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'tw3-blog-card' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" class="tw3-blog-card__media"><?php the_post_thumbnail( 'tw3-card' ); ?></a>
					<?php endif; ?>
					<div class="tw3-blog-card__body">
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
						<a class="tw3-link-arrow" href="<?php the_permalink(); ?>"><?php _e( 'Read more', 'targetweb3' ); ?> <span class="dashicons dashicons-arrow-right-alt"></span></a>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
		<div class="tw3-pagination"><?php the_posts_pagination(); ?></div>
	<?php else : ?>
		<p><?php _e( 'Nothing found.', 'targetweb3' ); ?></p>
	<?php endif; ?>
</main>
<?php get_sidebar(); get_footer(); ?>
