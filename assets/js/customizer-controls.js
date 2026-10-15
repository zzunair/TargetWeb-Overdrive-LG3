/* global jQuery, wp */
(function ($) {
	'use strict';

	var ICONS = [
		'star-filled','admin-generic','dismiss','leaf','flag','awards',
		'plus-alt2','money-alt','shield','yes-alt','admin-tools','car',
		'location-alt','phone','email','clock','performance','admin-home',
		'arrow-up-alt2','arrow-right-alt2','groups','store'
	];

	function fieldTemplate( field, value, rowIndex ) {
		var val = value === undefined || value === null ? '' : value;
		var name = 'gl_field_' + field.key + '_' + rowIndex;

		switch ( field.type ) {

			case 'textarea':
				return '<div class="gl-repeater__field gl-repeater__field--full">' +
					'<label>' + field.label + '</label>' +
					'<textarea data-key="' + field.key + '" rows="3">' + escapeHtml( val ) + '</textarea>' +
					'</div>';

			case 'number':
				return '<div class="gl-repeater__field">' +
					'<label>' + field.label + '</label>' +
					'<input type="number" min="1" max="5" data-key="' + field.key + '" value="' + escapeHtml( val ) + '">' +
					'</div>';

			case 'select':
				var opts = ( field.options || [] ).map( function ( o ) {
					var sel = ( o === val ) ? ' selected' : '';
					return '<option value="' + o + '"' + sel + '>' + ( o === '' ? '— None —' : o ) + '</option>';
				} ).join( '' );
				return '<div class="gl-repeater__field">' +
					'<label>' + field.label + '</label>' +
					'<select data-key="' + field.key + '">' + opts + '</select>' +
					'</div>';

			case 'icon':
				var iconOpts = '<option value=""' + ( val ? '' : ' selected' ) + '>— None —</option>' + ICONS.map( function ( ic ) {
					var sel = ( ic === val ) ? ' selected' : '';
					return '<option value="' + ic + '"' + sel + '>' + ic + '</option>';
				} ).join( '' );
				return '<div class="gl-repeater__field">' +
					'<label>' + field.label + '</label>' +
					'<div class="gl-icon-field">' +
						( val ? '<span class="dashicons dashicons-' + escapeHtml( val ) + ' gl-icon-preview"></span>' : '<span class="gl-icon-preview gl-icon-preview--none">—</span>' ) +
						'<select data-key="' + field.key + '">' + iconOpts + '</select>' +
					'</div>' +
					'</div>';

			case 'image':
				return '<div class="gl-repeater__field gl-repeater__field--full">' +
					'<label>' + field.label + '</label>' +
					'<div class="gl-image-field">' +
						'<div class="gl-image-field__preview" style="' + ( val ? 'background-image:url(' + val + ')' : '' ) + '">' +
							( val ? '' : '<span class="dashicons dashicons-format-image"></span>' ) +
						'</div>' +
						'<div class="gl-image-field__buttons">' +
							'<button type="button" class="button gl-image-field__select">' + ( val ? 'Replace' : 'Upload' ) + '</button>' +
							( val ? '<button type="button" class="button-link gl-image-field__remove">Remove</button>' : '' ) +
						'</div>' +
						'<input type="hidden" data-key="' + field.key + '" value="' + escapeHtml( val ) + '">' +
					'</div>' +
					'</div>';

			case 'url':
				return '<div class="gl-repeater__field">' +
					'<label>' + field.label + '</label>' +
					'<input type="text" data-key="' + field.key + '" value="' + escapeHtml( val ) + '" placeholder="#">' +
					'</div>';

			default: // text
				return '<div class="gl-repeater__field">' +
					'<label>' + field.label + '</label>' +
					'<input type="text" data-key="' + field.key + '" value="' + escapeHtml( val ) + '">' +
					'</div>';
		}
	}

	function escapeHtml( str ) {
		return String( str ).replace( /[&<>"']/g, function ( m ) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ m ];
		} );
	}

	function rowTitle( row, schema ) {
		var titleField = schema.find( function ( f ) { return f.key === 'title' || f.key === 'name' || f.key === 'question'; } );
		if ( titleField && row[ titleField.key ] ) return row[ titleField.key ];
		return 'Untitled';
	}

	function GlRepeater( el ) {
		$( el ).data( 'gl-initialized', true );
		this.$el = $( el );
		this.$items = this.$el.find( '.gl-repeater__items' );
		this.$hidden = this.$el.find( '.gl-repeater__value' );
		this.schema = JSON.parse( this.$el.attr( 'data-schema' ) || '[]' );
		this.itemLabel = this.$el.attr( 'data-item-label' ) || 'Item';
		this.maxItems = parseInt( this.$el.attr( 'data-max-items' ), 10 ) || 0;

		var raw = this.$hidden.val();
		try { this.rows = JSON.parse( raw ) || []; } catch ( e ) { this.rows = []; }

		this.render();
		this.bindGlobal();
	}

	GlRepeater.prototype.bindGlobal = function () {
		var self = this;
		this.$el.find( '.gl-repeater__add' ).on( 'click', function () {
			if ( self.maxItems && self.rows.length >= self.maxItems ) return;
			var blank = {};
			self.schema.forEach( function ( f ) { blank[ f.key ] = f.type === 'number' ? 5 : ''; } );
			self.rows.push( blank );
			self.render();
			self.commit();
			// Auto-expand the newly added row.
			self.$items.find( '.gl-repeater__row' ).last().addClass( 'is-open' );
		} );
	};

	GlRepeater.prototype.render = function () {
		var self = this;
		this.$items.empty();

		this.rows.forEach( function ( row, index ) {
			var $row = $( '<div class="gl-repeater__row"></div>' ).attr( 'data-index', index );

			var $head = $(
				'<div class="gl-repeater__row-head">' +
					'<span class="gl-repeater__drag dashicons dashicons-menu"></span>' +
					'<span class="gl-repeater__row-title"></span>' +
					'<span class="gl-repeater__row-actions">' +
						'<button type="button" class="gl-repeater__up" title="Move up"><span class="dashicons dashicons-arrow-up-alt2"></span></button>' +
						'<button type="button" class="gl-repeater__down" title="Move down"><span class="dashicons dashicons-arrow-down-alt2"></span></button>' +
						'<button type="button" class="gl-repeater__remove" title="Remove"><span class="dashicons dashicons-trash"></span></button>' +
					'</span>' +
				'</div>'
			);
			$head.find( '.gl-repeater__row-title' ).text( ( index + 1 ) + '. ' + rowTitle( row, self.schema ) );

			var $body = $( '<div class="gl-repeater__row-body"></div>' );
			self.schema.forEach( function ( field ) {
				$body.append( fieldTemplate( field, row[ field.key ], index ) );
			} );

			$row.append( $head ).append( $body );
			self.$items.append( $row );
		} );

		this.bindRowEvents();
	};

	GlRepeater.prototype.bindRowEvents = function () {
		var self = this;

		this.$items.find( '.gl-repeater__row-head' ).on( 'click', function ( e ) {
			if ( $( e.target ).closest( '.gl-repeater__row-actions' ).length ) return;
			$( this ).closest( '.gl-repeater__row' ).toggleClass( 'is-open' );
		} );

		this.$items.find( '.gl-repeater__remove' ).on( 'click', function () {
			var i = $( this ).closest( '.gl-repeater__row' ).data( 'index' );
			self.rows.splice( i, 1 );
			self.render();
			self.commit();
		} );

		this.$items.find( '.gl-repeater__up' ).on( 'click', function () {
			var i = $( this ).closest( '.gl-repeater__row' ).data( 'index' );
			if ( i === 0 ) return;
			var tmp = self.rows[ i - 1 ];
			self.rows[ i - 1 ] = self.rows[ i ];
			self.rows[ i ] = tmp;
			self.render();
			self.commit();
		} );

		this.$items.find( '.gl-repeater__down' ).on( 'click', function () {
			var i = $( this ).closest( '.gl-repeater__row' ).data( 'index' );
			if ( i === self.rows.length - 1 ) return;
			var tmp = self.rows[ i + 1 ];
			self.rows[ i + 1 ] = self.rows[ i ];
			self.rows[ i ] = tmp;
			self.render();
			self.commit();
		} );

		this.$items.find( 'input[data-key], textarea[data-key], select[data-key]' ).on( 'input change', function () {
			var $field = $( this );
			var i = $field.closest( '.gl-repeater__row' ).data( 'index' );
			var key = $field.attr( 'data-key' );
			self.rows[ i ][ key ] = $field.val();

			if ( key === 'title' || key === 'name' || key === 'question' ) {
				$field.closest( '.gl-repeater__row' ).find( '.gl-repeater__row-title' ).text( ( i + 1 ) + '. ' + ( $field.val() || 'Untitled' ) );
			}
			if ( $field.closest( '.gl-icon-field' ).length ) {
				var $preview = $field.closest( '.gl-icon-field' ).find( '.gl-icon-preview' );
				if ( $field.val() ) {
					$preview.attr( 'class', 'dashicons dashicons-' + $field.val() + ' gl-icon-preview' ).text( '' );
				} else {
					$preview.attr( 'class', 'gl-icon-preview gl-icon-preview--none' ).text( '—' );
				}
			}
			self.commit();
		} );

		this.$items.find( '.gl-image-field__select' ).on( 'click', function ( e ) {
			e.preventDefault();
			var $wrap = $( this ).closest( '.gl-image-field' );
			var frame = wp.media( { title: 'Select Image', multiple: false, library: { type: 'image' } } );
			frame.on( 'select', function () {
				var attachment = frame.state().get( 'selection' ).first().toJSON();
				var url = attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;
				$wrap.find( 'input[data-key]' ).val( url ).trigger( 'change' );
				$wrap.find( '.gl-image-field__preview' ).css( 'background-image', 'url(' + url + ')' ).find( 'span' ).remove();
				$wrap.find( '.gl-image-field__select' ).text( 'Replace' );
				if ( ! $wrap.find( '.gl-image-field__remove' ).length ) {
					$wrap.find( '.gl-image-field__buttons' ).append( '<button type="button" class="button-link gl-image-field__remove">Remove</button>' );
					self.bindRowEvents();
				}
			} );
			frame.open();
		} );

		this.$items.find( '.gl-image-field__remove' ).on( 'click', function ( e ) {
			e.preventDefault();
			var $wrap = $( this ).closest( '.gl-image-field' );
			$wrap.find( 'input[data-key]' ).val( '' ).trigger( 'change' );
			$wrap.find( '.gl-image-field__preview' ).css( 'background-image', '' ).html( '<span class="dashicons dashicons-format-image"></span>' );
			$wrap.find( '.gl-image-field__select' ).text( 'Upload' );
			$( this ).remove();
		} );
	};

	GlRepeater.prototype.commit = function () {
		this.$hidden.val( JSON.stringify( this.rows ) ).trigger( 'change' );
	};

	function initAll() {
		$( '.gl-repeater' ).each( function () {
			if ( ! $( this ).data( 'gl-initialized' ) ) {
				new GlRepeater( this );
			}
		} );
	}

	$( document ).on( 'ready', initAll );

	// Re-init if the Customizer swaps sections/panels in via AJAX-loaded controls.
	if ( window.wp && wp.customize ) {
		wp.customize.bind( 'ready', initAll );
		wp.customize.control.bind( 'add', function () { setTimeout( initAll, 50 ); } );
	}

	/* =========================================================
	   Section order / visibility control
	   ========================================================= */

	function GlSectionOrder( el ) {
		$( el ).data( 'gl-initialized', true );
		this.$el = $( el );
		this.$list = this.$el.find( '.gl-section-order__list' );
		this.$hidden = this.$el.find( '.gl-section-order__value' );
		this.labels = JSON.parse( this.$el.attr( 'data-items' ) || '{}' );

		var raw = this.$hidden.val();
		try { this.rows = JSON.parse( raw ) || []; } catch ( e ) { this.rows = []; }

		// If empty (first load before any default resolved), build from labels.
		if ( ! this.rows.length ) {
			this.rows = Object.keys( this.labels ).map( function ( id ) {
				return { id: id, enabled: true };
			} );
		}

		this.render();
	}

	GlSectionOrder.prototype.render = function () {
		var self = this;
		this.$list.empty();

		this.rows.forEach( function ( row, index ) {
			var label = self.labels[ row.id ] || row.id;
			var $row = $(
				'<div class="gl-section-order__row' + ( row.enabled ? '' : ' is-disabled' ) + '" data-index="' + index + '">' +
					'<span class="gl-section-order__drag dashicons dashicons-menu"></span>' +
					'<label class="gl-section-order__check">' +
						'<input type="checkbox" ' + ( row.enabled ? 'checked' : '' ) + '>' +
						'<span>' + escapeHtml( label ) + '</span>' +
					'</label>' +
					'<span class="gl-section-order__actions">' +
						'<button type="button" class="gl-section-order__up" title="Move up"><span class="dashicons dashicons-arrow-up-alt2"></span></button>' +
						'<button type="button" class="gl-section-order__down" title="Move down"><span class="dashicons dashicons-arrow-down-alt2"></span></button>' +
					'</span>' +
				'</div>'
			);
			self.$list.append( $row );
		} );

		this.bindEvents();
	};

	GlSectionOrder.prototype.bindEvents = function () {
		var self = this;

		this.$list.find( 'input[type="checkbox"]' ).on( 'change', function () {
			var i = $( this ).closest( '.gl-section-order__row' ).data( 'index' );
			self.rows[ i ].enabled = $( this ).is( ':checked' );
			$( this ).closest( '.gl-section-order__row' ).toggleClass( 'is-disabled', ! self.rows[ i ].enabled );
			self.commit();
		} );

		this.$list.find( '.gl-section-order__up' ).on( 'click', function () {
			var i = $( this ).closest( '.gl-section-order__row' ).data( 'index' );
			if ( i === 0 ) return;
			var tmp = self.rows[ i - 1 ];
			self.rows[ i - 1 ] = self.rows[ i ];
			self.rows[ i ] = tmp;
			self.render();
			self.commit();
		} );

		this.$list.find( '.gl-section-order__down' ).on( 'click', function () {
			var i = $( this ).closest( '.gl-section-order__row' ).data( 'index' );
			if ( i === self.rows.length - 1 ) return;
			var tmp = self.rows[ i + 1 ];
			self.rows[ i + 1 ] = self.rows[ i ];
			self.rows[ i ] = tmp;
			self.render();
			self.commit();
		} );
	};

	GlSectionOrder.prototype.commit = function () {
		this.$hidden.val( JSON.stringify( this.rows ) ).trigger( 'change' );
	};

	function initSectionOrder() {
		$( '.gl-section-order' ).each( function () {
			if ( ! $( this ).data( 'gl-initialized' ) ) {
				new GlSectionOrder( this );
			}
		} );
	}

	$( document ).on( 'ready', initSectionOrder );
	if ( window.wp && wp.customize ) {
		wp.customize.bind( 'ready', initSectionOrder );
		wp.customize.control.bind( 'add', function () { setTimeout( initSectionOrder, 50 ); } );
	}

})( jQuery );
