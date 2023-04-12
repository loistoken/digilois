/**
 * Wolmart Plugin - Products Compare
 * 
 * @package Wolmart WordPress Theme
 * @version 1.0
 */
'use strict';
window.Wolmart || ( window.Wolmart = {} );

( function ( $ ) {
    Wolmart.productCompare = function () {
        function addToCompare( e ) {
            e.preventDefault();

            var button = $( this ),
                data = {
                    action: 'wolmart_add_to_compare',
                    id: button.data( 'product_id' ),
                    minicompare: $( '.header .compare-dropdown' ).length ? $( '.header .compare-dropdown' ).data( 'minicompare-type' ) : '',
                };

            Wolmart.doLoading( button, 'small' );

            // do ajax
            $.ajax( {
                type: 'post',
                url: wolmart_vars.ajax_url,
                data: data,
                dataType: 'json',
                success: function ( response ) {

                    Wolmart.endLoading( button );

                    if ( typeof response.count != 'undefined' ) {
                        if ( $( '.header .compare-dropdown .widget_compare_content' ).length ) {
                            $( '.header .compare-dropdown .widget_compare_content' ).html( $( response.minicompare ).find( '.widget_compare_content' ).html() );
                        }
                        $( document ).trigger( 'added_to_compare', response.popup_template );

                        button.addClass( 'added' );
                        button.attr( 'href', response.url );
                    }
                }
            } );
        }

        function removeFromCompare( e ) {
            e.preventDefault();

            var $this = $( this ),
                data = {
                    action: 'wolmart_remove_from_compare',
                    id: $this.data( 'product_id' ),
                };

            Wolmart.doLoading( $this, 'small' );

            // do ajax
            $.ajax( {
                type: 'post',
                url: wolmart_vars.ajax_url,
                data: data,
                dataType: 'json',
                success: function ( response ) {
                    // decrease compare count
                    if ( typeof response.count != 'undefined' ) {

                        Wolmart.endLoading( $this );

                        if ( $this.closest( '.compare-popup' ).length ) {
                            $this.closest( 'li' ).empty();
                            updateCompareBadgeCount( $( '.compare-popup .compare-heading mark' ), false );
                        } else if ( typeof response.compare_table != 'undefined' ) {
                            $this.closest( '.wolmart-compare-table' ).replaceWith( response.compare_table );
                        }

                        $( document ).trigger( 'removed_from_compare', data.id );
                    }
                }
            } );
        }

        function openCompareListPopup( e, popup ) {
            if ( popup ) {
                if ( 'offcanvas' == wolmart_vars.compare_popup_type ) {
                    var $compare = $( '.page-wrapper > .compare-popup' );

                    if ( !$compare.length ) {
                        // add compare html
                        $( '.page-wrapper' ).append( '<div class="compare-popup"></div><div class="compare-popup-overlay"></div>' );
                        $compare = $( '.page-wrapper > .compare-popup' );
                    }

                    $compare.html( popup );
                    Wolmart.slider( '.compare-popup .slider-wrapper', {
                        spaceBetween: 10,
                        slidesPerView: 'auto',
                        breakpoints: {
                            992: {
                                spaceBetween: 30,
                            },
                            768: {
                                spaceBetween: 20,
                            }
                        },
                        scrollbar: {
                            el: '.slider-scrollbar',
                            dragClass: 'slider-scrollbar-drag',
                            draggable: true,
                        },
                    } );
                    Wolmart.requestTimeout( function () {
                        $compare.addClass( 'show' );
                    }, 60 );
                } else {
                    Wolmart.minipopup.open( {
                        content: popup
                    } );
                }
            }

            if ( $( '.header .compare-open' ).length ) {
                var $count = $( '.header .compare-open' ).find( '.compare-count' );
                if ( $count.length ) {
                    updateCompareBadgeCount( $count );
                }
            }
        }

        function removedFromCompareList( e, prod_id ) {
            $( '.compare[data-product_id="' + prod_id + '"]' ).removeClass( 'added' );


            if ( $( '.header .compare-open' ).length ) {
                var $count = $( '.header .compare-open' ).find( '.compare-count' );
                var $dropdown = $( '.header .compare-dropdown' );
                if ( $count.length ) {
                    updateCompareBadgeCount( $count, false );
                }

                if ( $dropdown.find( '.mini-item' ).length > 1 ) {
                    $dropdown.find( '.remove_from_compare[data-product_id="' + prod_id + '"]' ).closest( '.mini-item' ).remove();
                } else {
                    $dropdown.find( '.widget_compare_content' ).html( $( 'script.wolmart-minicompare-no-item-html' ).html() );
                }
            }
        }

        function changeCompareItemPos( e ) {
            e.preventDefault();

            var $basicInfo = $( this ).closest( '.compare-basic-info' );

            if ( $basicInfo.find( '.d-loading' ).length ) {
                return;
            }

            var $button = $( this ),
                idx = $button.closest( '.compare-value' ).index() - 1;

            if ( $button.closest( '.compare-col' ).hasClass( 'last-col' ) && $button.hasClass( 'to-right' ) ) {
                return
            };

            $( this ).closest( '.wolmart-compare-table' ).find( '.compare-row' ).each(
                function () {
                    var $orgItem = $( this ).children( '.compare-value' ).eq( idx ),
                        $dstItem = $button.hasClass( 'to-left' ) ? $orgItem.prev() : $orgItem.next(),
                        orgMove = ( $button.hasClass( 'to-left' ) ? '-' : '' ) + '20%',
                        dstMove = ( $button.hasClass( 'to-left' ) ? '' : '-' ) + '20%';

                    if ( $dstItem.hasClass( 'compare-field' ) ) return;

                    $orgItem.animate(
                        {
                            left: orgMove
                        },
                        200,
                        function () {
                            $orgItem.css( 'left', '' );

                            if ( $button.hasClass( 'to-left' ) ) {
                                $orgItem.after( $dstItem );
                            } else {
                                $orgItem.before( $dstItem );
                            }
                        }
                    );

                    $dstItem.animate(
                        {
                            left: dstMove
                        },
                        200,
                        function () {
                            $dstItem.css( 'left', '' );
                        }
                    );

                    setTimeout( function () {
                        if ( $dstItem.hasClass( 'last-col' ) || $orgItem.hasClass( 'last-col' ) ) {
                            $orgItem.toggleClass( 'last-col' );
                            $dstItem.toggleClass( 'last-col' );
                        }
                    }, 200 );
                }
            );
        }

        function updateCompareBadgeCount( $el, added = true ) {
            var qty = $el.html(),
                dq = added ? 1 : - 1;
            qty = qty.replace( /[^0-9]/, '' );
            qty = parseInt( qty ) + dq;
            if ( qty >= 0 && qty <= wolmart_vars.compare_limit ) {
                $el.html( qty );
            }
        }

        function closeComparePopup() {
            $( '.page-wrapper > .compare-popup' ).removeClass( 'show' );
        }

        function cleanCompareList( e ) {
            e.preventDefault();

            $( '.remove_from_compare' ).each( function () {
                var prod_id = $( this ).data( 'product_id' );
                $( '.compare[data-product_id="' + prod_id + '"]' ).removeClass( 'added' );
            } );

            $( '.compare-popup li' ).empty();
            $( '.compare-popup .compare-heading mark' ).text( '0' );

            $.post( wolmart_vars.ajax_url, {
                action: 'wolmart_clean_compare'
            } );

            $( '.header .compare-open .compare-count' ).html( '0' );
        }

        $( document )
            .on( 'click', '.product a.compare:not(.added)', addToCompare )
            .on( 'click', '.remove_from_compare', removeFromCompare )
            .on( 'click', '.compare-popup-overlay', closeComparePopup )
            .on( 'click', '.wolmart-compare-table .to-left, .wolmart-compare-table .to-right', changeCompareItemPos )
            .on( 'click', '.compare-clean', cleanCompareList )
            .on( 'added_to_compare', openCompareListPopup )
            .on( 'removed_from_compare', removedFromCompareList )
            .on( 'click', '.compare-offcanvas .compare-open', function ( e ) {
                $( this ).closest( '.compare-dropdown' ).toggleClass( 'opened' );
                e.preventDefault();
            } )
            .on( 'click', '.compare-offcanvas .btn-close', function ( e ) {
                e.preventDefault();
                $( this ).closest( '.compare-dropdown' ).removeClass( 'opened' );
            } )
            .on( 'click', '.compare-offcanvas .compare-overlay', function ( e ) {
                $( this ).closest( '.compare-dropdown' ).removeClass( 'opened' );
            } )
    }

    $( window ).on( 'wolmart_complete', Wolmart.productCompare );
} )( jQuery );