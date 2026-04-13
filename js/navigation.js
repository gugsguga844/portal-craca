/**
 * Portal Garganta — Navigation JS
 *
 * Handles mobile menu toggle with animated hamburger icon
 * and slide-in drawer behavior.
 */

( function() {
	'use strict';

	const toggle = document.getElementById( 'mobile-menu-toggle' );
	const drawer = document.getElementById( 'mobile-menu' );
	const header = document.getElementById( 'masthead' );

	if ( ! toggle || ! drawer ) {
		return;
	}

	// Set the header height CSS variable for the drawer offset
	function updateHeaderHeight() {
		if ( header ) {
			const h = header.offsetHeight;
			drawer.style.setProperty( '--header-height', h + 'px' );
			drawer.style.top = h + 'px';
		}
	}

	updateHeaderHeight();
	window.addEventListener( 'resize', updateHeaderHeight );

	// Toggle the menu
	toggle.addEventListener( 'click', function() {
		const isOpen = toggle.classList.contains( 'is-active' );

		if ( isOpen ) {
			// Close
			toggle.classList.remove( 'is-active' );
			drawer.classList.add( 'translate-x-full' );
			drawer.classList.remove( 'translate-x-0' );
			drawer.setAttribute( 'aria-hidden', 'true' );
			toggle.setAttribute( 'aria-expanded', 'false' );
			document.body.style.overflow = '';
		} else {
			// Open
			toggle.classList.add( 'is-active' );
			drawer.classList.remove( 'translate-x-full' );
			drawer.classList.add( 'translate-x-0' );
			drawer.setAttribute( 'aria-hidden', 'false' );
			toggle.setAttribute( 'aria-expanded', 'true' );
			document.body.style.overflow = 'hidden';
		}
	} );

	// Close menu when clicking a link
	const menuLinks = drawer.querySelectorAll( 'a' );
	menuLinks.forEach( function( link ) {
		link.addEventListener( 'click', function() {
			toggle.classList.remove( 'is-active' );
			drawer.classList.add( 'translate-x-full' );
			drawer.classList.remove( 'translate-x-0' );
			drawer.setAttribute( 'aria-hidden', 'true' );
			toggle.setAttribute( 'aria-expanded', 'false' );
			document.body.style.overflow = '';
		} );
	} );

	// Close menu on Escape key
	document.addEventListener( 'keydown', function( e ) {
		if ( e.key === 'Escape' && toggle.classList.contains( 'is-active' ) ) {
			toggle.click();
		}
	} );

} )();
