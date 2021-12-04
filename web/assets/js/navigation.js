/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
    var gridmax_secondary_container, gridmax_secondary_button, gridmax_secondary_menu, gridmax_secondary_links, gridmax_secondary_i, gridmax_secondary_len;

    gridmax_secondary_container = document.getElementById( 'gridmax-secondary-navigation' );
    if ( ! gridmax_secondary_container ) {
        return;
    }

    gridmax_secondary_button = gridmax_secondary_container.getElementsByTagName( 'button' )[0];
    if ( 'undefined' === typeof gridmax_secondary_button ) {
        return;
    }

    gridmax_secondary_menu = gridmax_secondary_container.getElementsByTagName( 'ul' )[0];

    // Hide menu toggle button if menu is empty and return early.
    if ( 'undefined' === typeof gridmax_secondary_menu ) {
        gridmax_secondary_button.style.display = 'none';
        return;
    }

    gridmax_secondary_menu.setAttribute( 'aria-expanded', 'false' );
    if ( -1 === gridmax_secondary_menu.className.indexOf( 'nav-menu' ) ) {
        gridmax_secondary_menu.className += ' nav-menu';
    }

    gridmax_secondary_button.onclick = function() {
        if ( -1 !== gridmax_secondary_container.className.indexOf( 'gridmax-toggled' ) ) {
            gridmax_secondary_container.className = gridmax_secondary_container.className.replace( ' gridmax-toggled', '' );
            gridmax_secondary_button.setAttribute( 'aria-expanded', 'false' );
            gridmax_secondary_menu.setAttribute( 'aria-expanded', 'false' );
        } else {
            gridmax_secondary_container.className += ' gridmax-toggled';
            gridmax_secondary_button.setAttribute( 'aria-expanded', 'true' );
            gridmax_secondary_menu.setAttribute( 'aria-expanded', 'true' );
        }
    };

    // Get all the link elements within the menu.
    gridmax_secondary_links    = gridmax_secondary_menu.getElementsByTagName( 'a' );

    // Each time a menu link is focused or blurred, toggle focus.
    for ( gridmax_secondary_i = 0, gridmax_secondary_len = gridmax_secondary_links.length; gridmax_secondary_i < gridmax_secondary_len; gridmax_secondary_i++ ) {
        gridmax_secondary_links[gridmax_secondary_i].addEventListener( 'focus', gridmax_secondary_toggleFocus, true );
        gridmax_secondary_links[gridmax_secondary_i].addEventListener( 'blur', gridmax_secondary_toggleFocus, true );
    }

    /**
     * Sets or removes .focus class on an element.
     */
    function gridmax_secondary_toggleFocus() {
        var self = this;

        // Move up through the ancestors of the current link until we hit .nav-menu.
        while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

            // On li elements toggle the class .focus.
            if ( 'li' === self.tagName.toLowerCase() ) {
                if ( -1 !== self.className.indexOf( 'gridmax-focus' ) ) {
                    self.className = self.className.replace( ' gridmax-focus', '' );
                } else {
                    self.className += ' gridmax-focus';
                }
            }

            self = self.parentElement;
        }
    }

    /**
     * Toggles `focus` class to allow submenu access on tablets.
     */
    ( function( gridmax_secondary_container ) {
        var touchStartFn, gridmax_secondary_i,
            parentLink = gridmax_secondary_container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

        if ( 'ontouchstart' in window ) {
            touchStartFn = function( e ) {
                var menuItem = this.parentNode, gridmax_secondary_i;

                if ( ! menuItem.classList.contains( 'gridmax-focus' ) ) {
                    e.preventDefault();
                    for ( gridmax_secondary_i = 0; gridmax_secondary_i < menuItem.parentNode.children.length; ++gridmax_secondary_i ) {
                        if ( menuItem === menuItem.parentNode.children[gridmax_secondary_i] ) {
                            continue;
                        }
                        menuItem.parentNode.children[gridmax_secondary_i].classList.remove( 'gridmax-focus' );
                    }
                    menuItem.classList.add( 'gridmax-focus' );
                } else {
                    menuItem.classList.remove( 'gridmax-focus' );
                }
            };

            for ( gridmax_secondary_i = 0; gridmax_secondary_i < parentLink.length; ++gridmax_secondary_i ) {
                parentLink[gridmax_secondary_i].addEventListener( 'touchstart', touchStartFn, false );
            }
        }
    }( gridmax_secondary_container ) );
} )();


( function() {
    var gridmax_primary_container, gridmax_primary_button, gridmax_primary_menu, gridmax_primary_links, gridmax_primary_i, gridmax_primary_len;

    gridmax_primary_container = document.getElementById( 'gridmax-primary-navigation' );
    if ( ! gridmax_primary_container ) {
        return;
    }

    gridmax_primary_button = gridmax_primary_container.getElementsByTagName( 'button' )[0];
    if ( 'undefined' === typeof gridmax_primary_button ) {
        return;
    }

    gridmax_primary_menu = gridmax_primary_container.getElementsByTagName( 'ul' )[0];

    // Hide menu toggle button if menu is empty and return early.
    if ( 'undefined' === typeof gridmax_primary_menu ) {
        gridmax_primary_button.style.display = 'none';
        return;
    }

    gridmax_primary_menu.setAttribute( 'aria-expanded', 'false' );
    if ( -1 === gridmax_primary_menu.className.indexOf( 'nav-menu' ) ) {
        gridmax_primary_menu.className += ' nav-menu';
    }

    gridmax_primary_button.onclick = function() {
        if ( -1 !== gridmax_primary_container.className.indexOf( 'gridmax-toggled' ) ) {
            gridmax_primary_container.className = gridmax_primary_container.className.replace( ' gridmax-toggled', '' );
            gridmax_primary_button.setAttribute( 'aria-expanded', 'false' );
            gridmax_primary_menu.setAttribute( 'aria-expanded', 'false' );
        } else {
            gridmax_primary_container.className += ' gridmax-toggled';
            gridmax_primary_button.setAttribute( 'aria-expanded', 'true' );
            gridmax_primary_menu.setAttribute( 'aria-expanded', 'true' );
        }
    };

    // Get all the link elements within the menu.
    gridmax_primary_links    = gridmax_primary_menu.getElementsByTagName( 'a' );

    // Each time a menu link is focused or blurred, toggle focus.
    for ( gridmax_primary_i = 0, gridmax_primary_len = gridmax_primary_links.length; gridmax_primary_i < gridmax_primary_len; gridmax_primary_i++ ) {
        gridmax_primary_links[gridmax_primary_i].addEventListener( 'focus', gridmax_primary_toggleFocus, true );
        gridmax_primary_links[gridmax_primary_i].addEventListener( 'blur', gridmax_primary_toggleFocus, true );
    }

    /**
     * Sets or removes .focus class on an element.
     */
    function gridmax_primary_toggleFocus() {
        var self = this;

        // Move up through the ancestors of the current link until we hit .nav-menu.
        while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

            // On li elements toggle the class .focus.
            if ( 'li' === self.tagName.toLowerCase() ) {
                if ( -1 !== self.className.indexOf( 'gridmax-focus' ) ) {
                    self.className = self.className.replace( ' gridmax-focus', '' );
                } else {
                    self.className += ' gridmax-focus';
                }
            }

            self = self.parentElement;
        }
    }

    /**
     * Toggles `focus` class to allow submenu access on tablets.
     */
    ( function( gridmax_primary_container ) {
        var touchStartFn, gridmax_primary_i,
            parentLink = gridmax_primary_container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

        if ( 'ontouchstart' in window ) {
            touchStartFn = function( e ) {
                var menuItem = this.parentNode, gridmax_primary_i;

                if ( ! menuItem.classList.contains( 'gridmax-focus' ) ) {
                    e.preventDefault();
                    for ( gridmax_primary_i = 0; gridmax_primary_i < menuItem.parentNode.children.length; ++gridmax_primary_i ) {
                        if ( menuItem === menuItem.parentNode.children[gridmax_primary_i] ) {
                            continue;
                        }
                        menuItem.parentNode.children[gridmax_primary_i].classList.remove( 'gridmax-focus' );
                    }
                    menuItem.classList.add( 'gridmax-focus' );
                } else {
                    menuItem.classList.remove( 'gridmax-focus' );
                }
            };

            for ( gridmax_primary_i = 0; gridmax_primary_i < parentLink.length; ++gridmax_primary_i ) {
                parentLink[gridmax_primary_i].addEventListener( 'touchstart', touchStartFn, false );
            }
        }
    }( gridmax_primary_container ) );
} )();