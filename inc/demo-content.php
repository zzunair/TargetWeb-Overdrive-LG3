<?php
/**
 * Setup page under Appearance ▸ TargetWeb - Overdrive Setup.
 *
 * @package TargetWeb3
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function tw3_find_post_by_title( $title, $post_type = 'page' ) {
	$q = new WP_Query( array(
		'post_type'      => $post_type,
		'title'          => $title,
		'post_status'    => 'publish',
		'posts_per_page' => 1,
		'no_found_rows'  => true,
	) );
	return $q->have_posts() ? $q->posts[0] : null;
}

function tw3_setup_admin_menu() {
	add_theme_page(
		__( 'TargetWeb - Overdrive Setup', 'targetweb3' ),
		__( 'TargetWeb - Overdrive Setup', 'targetweb3' ),
		'manage_options',
		'tw3-setup',
		'tw3_setup_page'
	);
}
add_action( 'admin_menu', 'tw3_setup_admin_menu' );

function tw3_ensure_homepage() {
	$home = tw3_find_post_by_title( 'Home', 'page' );
	if ( ! $home ) {
		$home_id = wp_insert_post( array(
			'post_type'     => 'page',
			'post_title'    => 'Home',
			'post_status'   => 'publish',
			'page_template' => 'front-page.php',
		) );
	} else {
		$home_id = $home->ID;
	}
	if ( $home_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}
	return $home_id;
}

function tw3_create_demo_pages_and_posts() {
	$pages = array(
		'About Us' => "<!-- wp:paragraph -->\n<p>Wholegoods supplies commercial-grade outdoor power equipment to landscaping crews, municipalities, and property owners who can't afford downtime. We stock, service, and stand behind every brand we sell.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Our team sizes equipment to the actual job — not the biggest number on the spec sheet — and our service bays keep your fleet running once the sale is done.</p>\n<!-- /wp:paragraph -->",
		'Support'  => "<!-- wp:paragraph -->\n<p>Need parts, a repair, or help troubleshooting a unit you bought elsewhere? Our service team handles most major commercial brands, with priority scheduling for fleet accounts.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Call or email using the contact details in our footer, or submit a request through the quote form and mention \"Support\" in the details field.</p>\n<!-- /wp:paragraph -->",
		'Blog'     => '',
	);

	$ids = array();
	foreach ( $pages as $title => $content ) {
		$existing = tw3_find_post_by_title( $title, 'page' );
		if ( $existing ) { $ids[ $title ] = $existing->ID; continue; }
		$id = wp_insert_post( array(
			'post_type'    => 'page',
			'post_title'   => $title,
			'post_content' => $content,
			'post_status'  => 'publish',
		) );
		if ( ! is_wp_error( $id ) ) $ids[ $title ] = $id;
	}

	if ( isset( $ids['Blog'] ) && ! get_option( 'page_for_posts' ) ) {
		update_option( 'page_for_posts', $ids['Blog'] );
	}

	$posts = array(
		array(
			'title'   => 'Choosing the Right Mower for Commercial Properties',
			'content' => "<!-- wp:paragraph -->\n<p>Acreage, obstacle density, and crew size all factor into whether a zero-turn, wide-area, or stand-on mower makes sense for a route. Here's how we size equipment for landscaping accounts.</p>\n<!-- /wp:paragraph -->",
		),
		array(
			'title'   => 'Generator Sizing 101: kW vs. Actual Load',
			'content' => "<!-- wp:paragraph -->\n<p>Oversizing a generator wastes fuel; undersizing trips breakers under load. We walk through calculating starting watts vs. running watts before recommending a unit.</p>\n<!-- /wp:paragraph -->",
		),
		array(
			'title'   => 'Fleet Maintenance Schedules That Actually Get Followed',
			'content' => "<!-- wp:paragraph -->\n<p>A maintenance plan only works if your crew can follow it between jobs. Here's the simplified schedule we recommend to landscaping and municipal fleet accounts.</p>\n<!-- /wp:paragraph -->",
		),
	);
	foreach ( $posts as $p ) {
		if ( tw3_find_post_by_title( $p['title'], 'post' ) ) continue;
		wp_insert_post( array(
			'post_type'    => 'post',
			'post_title'   => $p['title'],
			'post_content' => $p['content'],
			'post_status'  => 'publish',
		) );
	}

	return $ids;
}

function tw3_create_demo_menus() {
	$page_ids = array();
	foreach ( array( 'About Us', 'Support', 'Blog' ) as $title ) {
		$p = tw3_find_post_by_title( $title, 'page' );
		if ( $p ) $page_ids[ $title ] = $p->ID;
	}
	$home = trailingslashit( home_url( '/' ) );

	$menus = array(
		'primary' => array(
			'name'  => 'Primary Menu',
			'items' => array(
				array( 'title' => 'Equipment', 'url' => $home . '#equipment' ),
				array( 'title' => 'Brands',    'url' => $home . '#brands' ),
				array( 'title' => 'Financing', 'url' => $home . '#quote' ),
				array( 'title' => 'About Us',  'page' => 'About Us' ),
				array( 'title' => 'Support',   'page' => 'Support' ),
				array( 'title' => 'Contact',   'url' => $home . '#quote' ),
			),
		),
		'footer-equipment' => array(
			'name'  => 'Footer — Equipment',
			'items' => array(
				array( 'title' => 'Lawn Mowers', 'url' => $home . '#equipment' ),
				array( 'title' => 'Chainsaws',   'url' => $home . '#equipment' ),
				array( 'title' => 'Generators',  'url' => $home . '#equipment' ),
				array( 'title' => 'Commercial',  'url' => $home . '#equipment' ),
			),
		),
	);

	$locations = get_theme_mod( 'nav_menu_locations', array() );

	foreach ( $menus as $location => $data ) {
		$menu = wp_get_nav_menu_object( $data['name'] );

		if ( ! $menu ) {
			$menu_id = wp_create_nav_menu( $data['name'] );
			foreach ( $data['items'] as $item ) {
				if ( isset( $item['page'] ) && isset( $page_ids[ $item['page'] ] ) ) {
					wp_update_nav_menu_item( $menu_id, 0, array(
						'menu-item-title'     => $item['title'],
						'menu-item-object-id' => $page_ids[ $item['page'] ],
						'menu-item-object'    => 'page',
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
					) );
				} else {
					wp_update_nav_menu_item( $menu_id, 0, array(
						'menu-item-title'  => $item['title'],
						'menu-item-url'    => $item['url'],
						'menu-item-status' => 'publish',
					) );
				}
			}
		} else {
			$menu_id = $menu->term_id;
		}

		if ( empty( $locations[ $location ] ) ) {
			$locations[ $location ] = $menu_id;
		}
	}

	set_theme_mod( 'nav_menu_locations', $locations );
}

function tw3_on_activation() {
	tw3_ensure_homepage();
	tw3_create_demo_pages_and_posts();
	tw3_create_demo_menus();
}
add_action( 'after_switch_theme', 'tw3_on_activation' );

function tw3_setup_page() {
	$front_page_set = 'page' === get_option( 'show_on_front' ) && get_option( 'page_on_front' );
	?>
	<div class="wrap">
		<h1><?php _e( 'TargetWeb - Overdrive — Theme Setup', 'targetweb3' ); ?></h1>
		<p><?php _e( 'The homepage ships fully populated — categories, brands, why-us tiles, and every text field are all real, editable content already. Go to Appearance ▸ Customize ▸ "⚙ TargetWeb - Overdrive Theme Options" to add your own photos and edit any text, or use the tools below.', 'targetweb3' ); ?></p>

		<?php if ( $front_page_set ) : ?>
			<div class="notice notice-success inline"><p><?php _e( 'Your homepage is set correctly.', 'targetweb3' ); ?></p></div>
		<?php endif; ?>

		<form method="post" style="margin-bottom:28px;">
			<?php wp_nonce_field( 'tw3_setup_homepage', 'tw3_setup_nonce' ); ?>
			<button type="submit" name="tw3_setup_homepage" class="button button-primary">
				<?php echo $front_page_set ? __( 'Re-confirm Homepage', 'targetweb3' ) : __( 'Set Up Homepage', 'targetweb3' ); ?>
			</button>
		</form>

		<hr>
		<h2><?php _e( 'Demo pages, blog posts & menus', 'targetweb3' ); ?></h2>
		<p class="description"><?php _e( 'Creates About Us / Support / Blog pages, 3 sample blog posts, and populates the Primary Menu plus the footer Equipment menu — safe to run more than once.', 'targetweb3' ); ?></p>
		<form method="post" style="margin-bottom:28px;">
			<?php wp_nonce_field( 'tw3_setup_menus', 'tw3_menus_nonce' ); ?>
			<button type="submit" name="tw3_setup_menus" class="button button-primary">
				<?php _e( 'Create Demo Pages & Menus', 'targetweb3' ); ?>
			</button>
		</form>

		<hr>
		<h2><?php _e( 'Reset ALL theme text/settings to demo defaults', 'targetweb3' ); ?></h2>
		<p class="description"><?php _e( 'Clears every text, color, and image setting and restores the full demo. Categories / Brands / Why Choose Us are reset by the button below, separately.', 'targetweb3' ); ?></p>
		<form method="post" style="margin-bottom:28px;">
			<?php wp_nonce_field( 'tw3_reset_all', 'tw3_reset_all_nonce' ); ?>
			<button type="submit" name="tw3_reset_all" class="button" onclick="return confirm('<?php echo esc_js( __( 'Reset every theme text, color, and image setting to the demo defaults? This cannot be undone.', 'targetweb3' ) ); ?>');">
				<?php _e( 'Reset All Theme Settings', 'targetweb3' ); ?>
			</button>
		</form>

		<hr>
		<h2><?php _e( 'Reset content blocks to demo defaults', 'targetweb3' ); ?></h2>
		<p class="description"><?php _e( 'Clears edits to Equipment Categories, Brands, and Why Choose Us tiles and restores the original demo rows.', 'targetweb3' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( 'tw3_reset_blocks', 'tw3_reset_nonce' ); ?>
			<button type="submit" name="tw3_reset_blocks" class="button" onclick="return confirm('<?php echo esc_js( __( 'Reset all content blocks to demo defaults? This cannot be undone.', 'targetweb3' ) ); ?>');">
				<?php _e( 'Reset Content Blocks', 'targetweb3' ); ?>
			</button>
		</form>
	</div>
	<?php
}

function tw3_handle_setup_actions() {
	if ( ! current_user_can( 'manage_options' ) ) return;

	if ( isset( $_POST['tw3_setup_homepage'] ) && isset( $_POST['tw3_setup_nonce'] ) && wp_verify_nonce( $_POST['tw3_setup_nonce'], 'tw3_setup_homepage' ) ) {
		tw3_ensure_homepage();
		add_action( 'admin_notices', function () {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Homepage set.', 'targetweb3' ) . '</p></div>';
		} );
	}

	if ( isset( $_POST['tw3_setup_menus'] ) && isset( $_POST['tw3_menus_nonce'] ) && wp_verify_nonce( $_POST['tw3_menus_nonce'], 'tw3_setup_menus' ) ) {
		tw3_create_demo_pages_and_posts();
		tw3_create_demo_menus();
		add_action( 'admin_notices', function () {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Demo pages, posts, and menus created.', 'targetweb3' ) . '</p></div>';
		} );
	}

	if ( isset( $_POST['tw3_reset_all'] ) && isset( $_POST['tw3_reset_all_nonce'] ) && wp_verify_nonce( $_POST['tw3_reset_all_nonce'], 'tw3_reset_all' ) ) {
		foreach ( array_keys( tw3_text_defaults() ) as $key ) {
			remove_theme_mod( $key );
		}
		remove_theme_mod( 'tw3_section_order' );
		add_action( 'admin_notices', function () {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'All theme text, color, and image settings reset to demo defaults.', 'targetweb3' ) . '</p></div>';
		} );
	}

	if ( isset( $_POST['tw3_reset_blocks'] ) && isset( $_POST['tw3_reset_nonce'] ) && wp_verify_nonce( $_POST['tw3_reset_nonce'], 'tw3_reset_blocks' ) ) {
		remove_theme_mod( 'tw3_categories_repeater' );
		remove_theme_mod( 'tw3_brands_repeater' );
		remove_theme_mod( 'tw3_features_repeater' );
		add_action( 'admin_notices', function () {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Content blocks reset to demo defaults.', 'targetweb3' ) . '</p></div>';
		} );
	}
}
add_action( 'admin_init', 'tw3_handle_setup_actions' );
