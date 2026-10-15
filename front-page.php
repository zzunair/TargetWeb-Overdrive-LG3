<?php
/**
 * Front page — assembles homepage sections in whatever order and
 * visibility is set under Customize > ↕ Homepage Section Order.
 *
 * @package TargetWeb3
 */

get_header();

$registry = tw3_section_registry();
$order    = tw3_get_section_order();
?>

<main id="primary" class="tw3-main">
	<?php
	foreach ( $order as $row ) {
		if ( empty( $row['enabled'] ) ) continue;
		$id = $row['id'];
		if ( ! isset( $registry[ $id ] ) ) continue;
		get_template_part( 'template-parts/' . $registry[ $id ]['template'] );
	}
	?>
</main>

<?php get_footer(); ?>
