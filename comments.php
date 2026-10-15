<?php
/** Comments template. @package TargetWeb3 */
if ( post_password_required() ) return;
?>
<div class="tw3-comments">
	<?php if ( have_comments() ) : ?>
		<h3><?php comments_number( __( 'No Comments', 'targetweb3' ), __( '1 Comment', 'targetweb3' ), __( '% Comments', 'targetweb3' ) ); ?></h3>
		<ol class="tw3-comment-list"><?php wp_list_comments( array( 'style' => 'ol' ) ); ?></ol>
		<?php the_comments_pagination(); ?>
	<?php endif; ?>
	<?php comment_form(); ?>
</div>
