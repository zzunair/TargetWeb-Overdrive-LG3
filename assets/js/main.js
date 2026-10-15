(function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {

		/* ---------- Mobile menu toggle ---------- */
		var toggle = document.querySelector( '.tw3-mobile-toggle' );
		var menu   = document.getElementById( 'tw3-mobile-menu' );
		if ( toggle && menu ) {
			toggle.addEventListener( 'click', function () {
				var isOpen = menu.classList.toggle( 'is-open' );
				toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
			} );
		}

		/* ---------- Category popup modal ---------- */
		var modal = document.getElementById( 'tw3-category-modal' );
		var data  = window.tw3CategoryData || [];

		if ( modal ) {
			var titleEl = document.getElementById( 'tw3-modal-title' );
			var descEl  = document.getElementById( 'tw3-modal-description' );
			var imgEl   = document.getElementById( 'tw3-modal-image' );
			var ctaEl   = document.getElementById( 'tw3-modal-cta' );

			function openModal( index ) {
				var item = data[ index ];
				if ( ! item ) return;

				titleEl.textContent = item.title || '';
				descEl.textContent  = item.popup_description || '';

				if ( item.image ) {
					imgEl.src = item.image;
					imgEl.alt = item.title || '';
					imgEl.parentElement.style.display = '';
				} else {
					imgEl.parentElement.style.display = 'none';
				}

				ctaEl.textContent = item.popup_cta_text || 'Request a Quote';
				ctaEl.setAttribute( 'href', item.popup_cta_link || '#quote' );

				modal.classList.add( 'is-open' );
				modal.setAttribute( 'aria-hidden', 'false' );
				document.body.style.overflow = 'hidden';
			}

			function closeModal() {
				modal.classList.remove( 'is-open' );
				modal.setAttribute( 'aria-hidden', 'true' );
				document.body.style.overflow = '';
			}

			document.querySelectorAll( '[data-tw3-cat-index]' ).forEach( function ( card ) {
				card.addEventListener( 'click', function () {
					openModal( parseInt( card.getAttribute( 'data-tw3-cat-index' ), 10 ) );
				} );
			} );

			modal.querySelectorAll( '[data-tw3-modal-close]' ).forEach( function ( el ) {
				el.addEventListener( 'click', closeModal );
			} );

			document.addEventListener( 'keydown', function ( e ) {
				if ( 'Escape' === e.key && modal.classList.contains( 'is-open' ) ) closeModal();
			} );
		}

	} );
})();
