jQuery(document).ready(function($) {
    'use strict';

    if(gridmax_ajax_object.primary_menu_active){
        $(".gridmax-nav-primary .gridmax-primary-nav-menu").addClass("gridmax-primary-responsive-menu");

        $( ".gridmax-primary-responsive-menu-icon" ).on( "click", function() {
            $(this).next(".gridmax-nav-primary .gridmax-primary-nav-menu").slideToggle();
        });

        $(window).on( "resize", function() {
            if(window.innerWidth > 1112) {
                $(".gridmax-nav-primary .gridmax-primary-nav-menu, nav .sub-menu, nav .children").removeAttr("style");
                $(".gridmax-primary-responsive-menu > li").removeClass("gridmax-primary-menu-open");
            }
        });

        $( ".gridmax-primary-responsive-menu > li" ).on( "click", function(event) {
            if (event.target !== this)
            return;
            $(this).find(".sub-menu:first").toggleClass('gridmax-submenu-toggle').parent().toggleClass("gridmax-primary-menu-open");
            $(this).find(".children:first").toggleClass('gridmax-submenu-toggle').parent().toggleClass("gridmax-primary-menu-open");
        });

        $( "div.gridmax-primary-responsive-menu > ul > li" ).on( "click", function(event) {
            if (event.target !== this)
                return;
            $(this).find("ul:first").toggleClass('gridmax-submenu-toggle').parent().toggleClass("gridmax-primary-menu-open");
        });
    }

    if($(".gridmax-header-icon-search").length){
        $(".gridmax-header-icon-search").on('click', function (e) {
            e.preventDefault();
            //document.getElementById("gridmax-search-overlay-wrap").style.display = "block";
            $("#gridmax-search-overlay-wrap").fadeIn();
            const gridmax_focusableelements = 'button, [href], input';
            const gridmax_search_modal = document.querySelector('#gridmax-search-overlay-wrap');
            const gridmax_firstfocusableelement = gridmax_search_modal.querySelectorAll(gridmax_focusableelements)[0];
            const gridmax_focusablecontent = gridmax_search_modal.querySelectorAll(gridmax_focusableelements);
            const gridmax_lastfocusableelement = gridmax_focusablecontent[gridmax_focusablecontent.length - 1];
            document.addEventListener('keydown', function(e) {
              let isTabPressed = e.key === 'Tab' || e.keyCode === 9;
              if (!isTabPressed) {
                return;
              }
              if (e.shiftKey) {
                if (document.activeElement === gridmax_firstfocusableelement) {
                  gridmax_lastfocusableelement.focus();
                  e.preventDefault();
                }
              } else {
                if (document.activeElement === gridmax_lastfocusableelement) {
                  gridmax_firstfocusableelement.focus();
                  e.preventDefault();
                }
              }
            });
            gridmax_firstfocusableelement.focus();
        });
    }

    if($(".gridmax-search-closebtn").length){
        $(".gridmax-search-closebtn").on('click', function (e) {
            e.preventDefault();
            //document.getElementById("gridmax-search-overlay-wrap").style.display = "none";
            $("#gridmax-search-overlay-wrap").fadeOut();
        });
    }

    if(gridmax_ajax_object.fitvids_active){
        $(".entry-content, .widget").fitVids();
    }

    if(gridmax_ajax_object.backtotop_active){
        if($(".gridmax-scroll-top").length){
            var gridmax_scroll_button = $( '.gridmax-scroll-top' );
            gridmax_scroll_button.hide();

            $( window ).on( "scroll", function() {
                if ( $( window ).scrollTop() < 20 ) {
                    $( '.gridmax-scroll-top' ).fadeOut();
                } else {
                    $( '.gridmax-scroll-top' ).fadeIn();
                }
            } );

            gridmax_scroll_button.on( "click", function() {
                $( "html, body" ).animate( { scrollTop: 0 }, 300 );
                return false;
            } );
        }
    }

    if(gridmax_ajax_object.sticky_header_active){

    // grab the initial top offset of the navigation 
    var gridmaxstickyheadertop = $('#gridmax-header-end').offset().top;
    
    // our function that decides weather the navigation bar should have "fixed" css position or not.
    var gridmaxstickyheader = function(){
        var gridmaxscrolltop = $(window).scrollTop(); // our current vertical position from the top
             
        // if we've scrolled more than the navigation, change its position to fixed to stick to top,
        // otherwise change it back to relative

        if(gridmax_ajax_object.sticky_header_mobile_active){
            if (gridmaxscrolltop > gridmaxstickyheadertop) {
                $('.gridmax-site-header').addClass('gridmax-fixed');
            } else {
                $('.gridmax-site-header').removeClass('gridmax-fixed');
            }
        } else {
            if(window.innerWidth > 1112) {
                if (gridmaxscrolltop > gridmaxstickyheadertop) {
                    $('.gridmax-site-header').addClass('gridmax-fixed');
                } else {
                    $('.gridmax-site-header').removeClass('gridmax-fixed');
                }
            }
        }
    };

    gridmaxstickyheader();
    // and run it again every time you scroll
    $(window).on( "scroll", function() {
        gridmaxstickyheader();
    });

    }

    if(gridmax_ajax_object.sticky_sidebar_active){
        $('.gridmax-main-wrapper, .gridmax-sidebar-one-wrapper').theiaStickySidebar({
            containerSelector: ".gridmax-content-wrapper",
            additionalMarginTop: 0,
            additionalMarginBottom: 0,
            minWidth: 960,
        });

        $(window).on( "resize", function() {
            $('.gridmax-main-wrapper, .gridmax-sidebar-one-wrapper').theiaStickySidebar({
                containerSelector: ".gridmax-content-wrapper",
                additionalMarginTop: 0,
                additionalMarginBottom: 0,
                minWidth: 960,
            });
        });
    }

});