/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
    // Site title and description.
    wp.customize( 'blogname', function( value ) {
        value.bind( function( to ) {
            $( '.gridmax-site-title a' ).text( to );
        } );
    } );
    wp.customize( 'blogdescription', function( value ) {
        value.bind( function( to ) {
            $( '.gridmax-site-description' ).text( to );
        } );
    } );
    // Header text color.
    wp.customize( 'header_textcolor', function( value ) {
        value.bind( function( to ) {
            if ( 'blank' === to ) {
                $( '.gridmax-site-title, .gridmax-site-description' ).css( {
                    'clip': 'rect(1px, 1px, 1px, 1px)',
                    'position': 'absolute'
                } );
            } else {
                $( '.gridmax-site-title, .gridmax-site-title a, .gridmax-site-description' ).css( {
                    'clip': 'auto',
                    'color': to,
                    'position': 'relative'
                } );
            }
        } );
    } );
    wp.customize( 'gridmax_options[header_text_hover_color]', function( value ) {
        value.bind( function( to ) {
            $('.gridmax-site-title a').on({
                mouseover: function () {
                    $(this).css( 'color', to );
                },
                mouseout: function () {
                    $(this).css( 'color', 'inherit' );
                },
                focus: function () {
                    $(this).css( 'color', to );
                },
                focusout: function () {
                    $(this).css( 'color', 'inherit' );
                }
            });
        });
    });
} )( jQuery );