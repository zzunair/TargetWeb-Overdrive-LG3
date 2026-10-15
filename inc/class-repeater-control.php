<?php
/**
 * A generic "repeater" Customizer control.
 *
 * Lets a non-technical person add, remove, reorder, and edit rows of
 * structured content (categories, services, testimonials, FAQs, etc.)
 * entirely from Appearance > Customize — no separate admin screens,
 * no plugins. Modeled after the block/section editors people are used
 * to from Shopify or Wix.
 *
 * Data is stored as a single JSON string in one theme_mod. The field
 * schema (which columns each row has, and what type of input each is)
 * is passed in per-control so one control class covers every block.
 *
 * @package TargetWeb3
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) return;

class TW3_Repeater_Control extends WP_Customize_Control {

	public $type = 'tw3-repeater';

	/** @var array Field schema: array of ['key'=>'title','label'=>'Title','type'=>'text|textarea|number|url|select|icon|image','options'=>[...]] */
	public $schema = array();

	/** @var string Singular label used on the "+ Add" button, e.g. "Category" */
	public $item_label = 'Item';

	/** @var int Max rows allowed, 0 = unlimited */
	public $max_items = 0;

	public function enqueue() {
		wp_enqueue_media();
		wp_enqueue_style( 'tw3-customizer-controls', TW3_URI . '/assets/css/customizer-controls.css', array(), TW3_VERSION );
		wp_enqueue_script( 'tw3-customizer-controls', TW3_URI . '/assets/js/customizer-controls.js', array( 'jquery', 'customize-controls' ), TW3_VERSION, true );
	}

	public function render_content() {
		$value = $this->value();
		?>
		<div class="gl-repeater-control">
			<?php if ( $this->label ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
			<?php if ( $this->description ) : ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>

			<div class="gl-repeater"
				data-schema="<?php echo esc_attr( wp_json_encode( $this->schema ) ); ?>"
				data-item-label="<?php echo esc_attr( $this->item_label ); ?>"
				data-max-items="<?php echo esc_attr( $this->max_items ); ?>">

				<div class="gl-repeater__items"></div>

				<button type="button" class="button button-secondary gl-repeater__add">
					<span class="dashicons dashicons-plus-alt2"></span>
					<?php echo esc_html( sprintf( __( 'Add %s', 'targetweb3' ), $this->item_label ) ); ?>
				</button>

				<input type="hidden" class="gl-repeater__value" <?php $this->link(); ?> value="<?php echo esc_attr( $value ); ?>">
			</div>
		</div>
		<?php
	}
}
