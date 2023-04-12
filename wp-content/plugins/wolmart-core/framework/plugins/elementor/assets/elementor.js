/**
 * Wolmart Elementor Preview
 * 
 * @package Wolmart Core WordPress plugin
 * @since 1.0
 */
'use strict';

( function ( $ ) {
    function get_creative_class( $grid_item ) {
        var ex_class = '';
        if ( undefined != $grid_item ) {
            ex_class = 'grid-item ';
            Object.entries( $grid_item ).forEach( function ( item ) {
                if ( item[ 1 ] ) {
                    ex_class += item[ 0 ] + '-' + item[ 1 ] + ' ';
                }
            } )
        }
        return ex_class;
    }

    function gcd( $a, $b ) {
        while ( $b ) {
            var $r = $a % $b;
            $a = $b;
            $b = $r;
        }
        return $a;
    }

    function get_creative_grid_item_css( $id, $layout, $height, $height_ratio ) {
        if ( 'undefined' == typeof $layout ) {
            return;
        }
        var $deno = [];
        var $numer = [];
        var $style = '';
        var $ws = { 'w': [], 'w-l': [], 'w-m': [], 'w-s': [] };
        var $hs = { 'h': [], 'h-l': [], 'h-m': [] };

        $style += '<style scope="">';
        $layout.map( function ( $grid_item ) {
            Object.entries( $grid_item ).forEach( function ( $info ) {
                if ( 'size' == $info[ 0 ] ) {
                    return;
                }

                var $num = $info[ 1 ].split( '-' );
                if ( undefined != $num[ 1 ] && -1 == $deno.indexOf( $num[ 1 ] ) ) {
                    $deno.push( $num[ 1 ] );
                }
                if ( -1 == $numer.indexOf( $num[ 0 ] ) ) {
                    $numer.push( $num[ 0 ] );
                }

                if ( ( 'w' == $info[ 0 ] || 'w-l' == $info[ 0 ] || 'w-m' == $info[ 0 ] || 'w-s' == $info[ 0 ] ) && -1 == $ws[ $info[ 0 ] ].indexOf( $info[ 1 ] ) ) {
                    $ws[ $info[ 0 ] ].push( $info[ 1 ] );
                } else if ( ( 'h' == $info[ 0 ] || 'h-l' == $info[ 0 ] || 'h-m' == $info[ 0 ] ) && -1 == $hs[ $info[ 0 ] ].indexOf( $info[ 1 ] ) ) {
                    $hs[ $info[ 0 ] ].push( $info[ 1 ] );
                }
            } );
        } );
        Object.entries( $ws ).forEach( function ( $w ) {
            if ( !$w[ 1 ].length ) {
                return;
            }

            if ( 'w-l' == $w[ 0 ] ) {
                $style += '@media (max-width: 991px) {';
            } else if ( 'w-m' == $w[ 0 ] ) {
                $style += '@media (max-width: 767px) {';
            } else if ( 'w-s' == $w[ 0 ] ) {
                $style += '@media (max-width: 575px) {';
            }

            $w[ 1 ].map( function ( $item ) {
                var $opts = $item.split( '-' );
                var $width = ( undefined == $opts[ 1 ] ? 100 : ( 100 * $opts[ 0 ] / $opts[ 1 ] ).toFixed( 4 ) );
                $style += '.elementor-element-' + $id + ' .grid-item.' + $w[ 0 ] + '-' + $item + '{flex:0 0 ' + $width + '%;width:' + $width + '%}';
            } )

            if ( 'w-l' == $w[ 0 ] || 'w-m' == $w[ 0 ] || 'w-s' == $w[ 0 ] ) {
                $style += '}';
            }
        } );
        Object.entries( $hs ).forEach( function ( $h ) {
            if ( !$h[ 1 ].length ) {
                return;
            }

            $h[ 1 ].map( function ( $item ) {
                var $opts = $item.split( '-' ), $value;
                if ( undefined != $opts[ 1 ] ) {
                    $value = $height * $opts[ 0 ] / $opts[ 1 ];
                } else {
                    $value = $height;
                }
                if ( 'h' == $h[ 0 ] ) {
                    $style += '.elementor-element-' + $id + ' .h-' + $item + '{height:' + $value.toFixed( 2 ) + 'px}';
                    $style += '@media (max-width: 767px) {';
                    $style += '.elementor-element-' + $id + ' .h-' + $item + '{height:' + ( $value * $height_ratio / 100 ).toFixed( 2 ) + 'px}';
                    $style += '}';
                } else if ( 'h-l' == $h[ 0 ] ) {
                    $style += '@media (max-width: 991px) {';
                    $style += '.elementor-element-' + $id + ' .h-l-' + $item + '{height:' + $value.toFixed( 2 ) + 'px}';
                    $style += '}';
                    $style += '@media (max-width: 767px) {';
                    $style += '.elementor-element-' + $id + ' .h-l-' + $item + '{height:' + ( $value * $height_ratio / 100 ).toFixed( 2 ) + 'px}';
                    $style += '}';
                } else if ( 'h-m' == $h[ 0 ] ) {
                    $style += '@media (max-width: 767px) {';
                    $style += '.elementor-element-' + $id + ' .h-m-' + $item + '{height:' + ( $value * $height_ratio / 100 ).toFixed( 2 ) + 'px}';
                    $style += '}';
                }
            } )
        } );
        var $lcm = 1;
        $deno.map( function ( $value ) {
            $lcm = $lcm * $value / gcd( $lcm, $value );
        } );
        var $gcd = $numer[ 0 ];
        $numer.map( function ( $value ) {
            $gcd = gcd( $gcd, $value );
        } );
        var $sizer = Math.floor( 100 * $gcd / $lcm * 10000 ) / 10000;
        $style += '.elementor-element-' + $id + ' .grid' + '>.grid-space{flex: 0 0 ' + ( $sizer < 0.01 ? 100 : $sizer ) + '%;width:' + ( $sizer < 0.01 ? 100 : $sizer ) + '%}';
        $style += '</style>';
        return $style;
    }

    function initSlider( $el ) {
        if ( $el.length != 1 ) {
            return;
        }

        // var customDotsHtml = '';
        if ( $el.data( 'slider' ) ) {
            $el.data( 'slider' ).destroy();
            $el.children( '.slider-slide' ).removeClass( 'slider-slide' );
            $el.parent().siblings( '.slider-thumb-dots' ).off( 'click.preview' );
            $el.removeData( 'slider' );
        }

        Wolmart.slider( $el, {}, true );

        // Register events for thumb dots
        var $dots = $el.parent().siblings( '.slider-thumb-dots' );
        if ( $dots.length ) {
            var slider = $el.data( 'slider' );
            $dots.on( 'click.preview', 'button', function () {
                if ( !slider.destroyed ) {
                    slider.slideTo( $( this ).index(), 300 );
                }
            } );
            slider && slider.on( 'transitionEnd', function () {
                $dots.children().removeClass( 'active' ).eq( this.realIndex ).addClass( 'active' );
            } )
        }

        Object.setPrototypeOf( $el.get( 0 ), HTMLElement.prototype );
    }

    var WolmartElementorPreview = {
        completed: false,
        fnArray: [],
        init: function () {
            var self = this;

            $( 'body' ).on( 'click', 'a', function ( e ) {
                e.preventDefault();
            } )

            // for section, column slider's thumbs dots
            $( '.elementor-section > .slider-thumb-dots' ).parent().addClass( 'flex-wrap' );
            $( '.elementor-column > .slider-thumb-dots' ).parent().addClass( 'flex-wrap' );

            elementorFrontend.hooks.addAction( 'frontend/element_ready/column', function ( $obj ) {
                self.completed ? self.initColumn( $obj ) : self.fnArray.push( {
                    fn: self.initColumn,
                    arg: $obj
                } );
            } );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/section', function ( $obj ) {
                self.completed ? self.initSection( $obj ) : self.fnArray.push( {
                    fn: self.initSection,
                    arg: $obj
                } );
            } );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function ( $obj ) {
                self.completed ? self.initWidgetAdvanced( $obj ) : self.fnArray.push( {
                    fn: self.initWidgetAdvanced,
                    arg: $obj
                } );
            } );

            elementorFrontend.hooks.addAction( 'refresh_page_css', function ( css ) {
                var $obj = $( 'style#wolmart_elementor_custom_css' );
                if ( !$obj.length ) {
                    $obj = $( '<style id="wolmart_elementor_custom_css"></style>' ).appendTo( 'head' );
                }
                css = css.replace( '/<script.*?\/script>/s', '' );
                $obj.html( css ).appendTo( 'head' );
            } );
        },
        onComplete: function () {
            var self = this;
            self.completed = true;

            // Edit menu easily 
            setTimeout( function () {
                $( '.wolmart-block.elementor.elementor-edit-area-active' ).closest( '.dropdown-box' ).css( { "visibility": "visible", "opacity": "1", "top": "100%", "transform": "translate3d(0, 0, 0)" } );
                $( '.wolmart-block.elementor.elementor-edit-area-active' ).parents( '.menu-item' ).addClass( 'show' );
            }, 2000 );

            $( '.wolmart-block[data-el-class]' ).each( function () {
                $( this ).addClass( $( this ).attr( 'data-el-class' ) ).removeAttr( 'data-el-class' );
            } );

            self.initWidgets();
            self.initGlobal();
            self.fnArray.forEach( function ( obj ) {
                if ( typeof obj == 'function' ) {
                    obj.call();
                } else if ( typeof obj == 'object' ) {
                    obj.fn.call( self, obj.arg );
                }
            } );
        },
        initWidgets: function () {
            var wolmart_widgets = [
                'wolmart_widget_products.default',
                'wolmart_widget_brands.default',
                'wolmart_widget_categories.default',
                'wolmart_widget_posts.default',
                'wolmart_widget_imagegallery.default',
                'wolmart_widget_single_product.default',
                'wolmart_widget_testimonial_group.default',
                'wolmart_sproduct_linked_products.default',
                'wolmart_sproduct_image.default',
                'wolmart_widget_products_tab.default',
                'wolmart_widget_products_single.default',
                'wolmart_widget_products_banner.default',
                'wolmart_widget_vendors.default',
            ];


            // Widgets for posts
            wolmart_widgets.forEach( function ( widget_name ) {
                elementorFrontend.hooks.addAction( 'frontend/element_ready/' + widget_name, function ( $obj ) {
                    if ( 'wolmart_widget_products.default' == widget_name ) {
                        Wolmart.menu.initMenu();
                    }

                    $obj.find( '.slider-wrapper' ).each( function () {
                        initSlider( $( this ) );
                    } )
                    Wolmart.isotopes( $obj.find( '.grid' ) );
                    Wolmart.countdown( $obj.find( '.countdown' ) );
                } );
            } );

            // Widget for countdown
            elementorFrontend.hooks.addAction( 'frontend/element_ready/wolmart_widget_countdown.default', function ( $obj ) {
                Wolmart.countdown( $obj.find( '.countdown' ) );
            } );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/wolmart_sproduct_flash_sale.default', function ( $obj ) {
                Wolmart.countdown( $obj.find( '.countdown' ) );
            } );

            elementorFrontend.hooks.addAction( 'frontend/element_ready/wolmart_sproduct_counter.default', function ( $obj ) {
                var $counterNumber = $obj.find( '.elementor-counter-number' );
                elementorFrontend.waypoint( $counterNumber, function () {
                    var data = $counterNumber.data(),
                        decimalDigits = data.toValue.toString().match( /\.(.*)/ );

                    if ( decimalDigits ) {
                        data.rounding = decimalDigits[ 1 ].length;
                    }

                    $counterNumber.numerator( data );
                } );
            } );

            // Widget for SVG floating
            elementorFrontend.hooks.addAction( 'frontend/element_ready/wolmart_widget_floating.default', function ( $obj ) {
                Wolmart.floatSVG( $obj.find( '.float-svg' ) );
            } );

            // Single Product Image Widget Issue
            var removeFigureMarginWidgets = [ 'sproduct_image', 'sproduct_fbt', 'sproduct_data_tab', 'sproduct_linked_products', 'sproduct_vendor_products', 'widget_single_product' ];
            removeFigureMarginWidgets.forEach( function ( widget_name ) {
                elementorFrontend.hooks.addAction( 'frontend/element_ready/wolmart_' + widget_name + '.default', function ( $obj ) {
                    $obj.addClass( 'elementor-widget-theme-post-content' );
                } );
            } )

            // Widget for banner
            elementorFrontend.hooks.addAction( 'frontend/element_ready/wolmart_widget_banner.default', function ( $obj ) {
                Wolmart.parallax( $obj.find( '.parallax' ) );
                Wolmart.appearAnimate( '.appear-animate' );
                jQuery( window ).trigger( 'appear.check' );

                if ( $obj.find( '.banner-stretch' ).length ) {
                    $obj.addClass( 'elementor-widget-wolmart_banner_stretch' );
                } else {
                    $obj.removeClass( 'elementor-widget-wolmart_banner_stretch' );
                }
            } );

            // Menu Widget
            elementorFrontend.hooks.addAction( 'frontend/element_ready/wolmart_widget_menu.default', function ( $obj ) {
                Wolmart.menu.initMenu( '.elementor-element-' + $obj.attr( 'data-id' ) );
            } );
        },
        initSection: function ( $obj ) {
            var $container = $obj.children( '.elementor-container' ),
                $row = 0 == $obj.find( '.elementor-row' ).length ? $container : $container.children( '.elementor-row' );

            if ( $row.attr( 'data-slider-class' ) ) {
                var sliderOptions = ' data-slider-options="' + $row.attr( 'data-slider-options' ) + '"';
                $row.wrapInner( '<div class="' + $row.attr( 'data-slider-class' ) + '"' + sliderOptions + '></div>' )
                    .removeAttr( 'data-slider-class' ).removeAttr( 'data-slider-options' );
                $row.children( '.slider-wrapper' ).children( ':not(.elementor-element)' ).remove().prependTo( $row );
            }

            if ( $obj.children( '.slider-thumb-dots' ).length ) {
                $obj.addClass( 'flex-wrap' );
            }

            $obj.removeData( '__parallax' );
            if ( 'parallax' == $row.data( 'class' ) ) {
                $obj.addClass( 'background-none' );
                $obj.addClass( 'parallax' )
                    .attr( 'data-plugin', 'parallax' )
                    .attr( 'data-image-src', $row.data( 'image-src' ) )
                    .attr( 'data-parallax-options', JSON.stringify( $row.data( 'parallax-options' ) ) );
                Wolmart.parallax( $obj );
            } else {
                $obj.removeClass( 'parallax' );
                $obj.removeClass( 'background-none' );
            }

            if ( $row.hasClass( 'banner-fixed' ) && $row.hasClass( 'banner' ) && 'use_background' != $row.data( 'class' ) ) {
                $obj.css( 'background', 'none' );
            } else {
                $obj.css( 'background', '' );
            }

            if ( $row.hasClass( 'grid' ) ) {
                $row.append( '<div class="grid-space"></div>' );
                Object.setPrototypeOf( $row.get( 0 ), HTMLElement.prototype );
                var timer = setTimeout( function () {
                    elementorFrontend.hooks.doAction( 'refresh_isotope_layout', timer, $row, true );
                } );
            } else {
                $row.siblings( 'style' ).remove();
                $row.children( '.grid-space' ).remove();
                $row.data( 'isotope' ) && $row.isotope( 'destroy' );
            }

            // Slider 
            if ( $row.hasClass( 'slider-wrapper' ) ) {
                if ( $row.data( 'slider' ) ) {
                    $row.data( 'slider' ) && $row.data( 'slider' ).update();
                } else {
                    initSlider( $row );
                }
            } else if ( $row.children( '.slider-wrapper' ).length ) {
                $row.children( '.slider-wrapper' ).children( ':not(.elementor-element)' ).remove().prependTo( $row );
                initSlider( $row.children( '.slider-wrapper' ) );
            }

            // Accordion
            if ( $row.hasClass( 'accordion' ) ) {
                setTimeout( function () {
                    var $card = $row.children( '.card' ).eq( 0 );
                    $card.find( '.card-header a' ).toggleClass( 'collapse' ).toggleClass( 'expand' );
                    $card.find( '.card-body' ).toggleClass( 'collapsed' ).toggleClass( 'expanded' );
                    $card.find( '.card-header a' ).trigger( 'click' );
                }, 300 );
            }
        },
        initColumn: function ( $obj ) {
            var $row = 0 == $obj.closest( '.elementor-row' ).length ? $obj.closest( '.elementor-container' ) : $obj.closest( '.elementor-row' ),
                $column = $obj.children( '.elementor-column-wrap' ),
                $wrapper = 0 == $obj.closest( '.elementor-row' ).length ? $row : $row.parent(),
                $classes = [];

            $column = 0 === $column.length ? $obj.children( '.elementor-widget-wrap' ) : $column;

            if ( $column.attr( 'data-slider-class' ) ) {
                var sliderOptions = ' data-slider-options="' + $column.attr( 'data-slider-options' ) + '"';
                $column.wrapInner( '<div class="' + $column.attr( 'data-slider-class' ) + '"' + sliderOptions + '></div>' )
                    .removeAttr( 'data-slider-class' ).removeAttr( 'data-slider-options' );
                $column.children( '.slider-wrapper' ).children( ':not(.elementor-element)' ).remove().prependTo( $column );
            }
            if ( $column.hasClass( 'slider-wrapper' ) && $column.siblings( '.slider-thumb-dots' ).length ) {
                $column.parent().addClass( 'flex-wrap' );
            }

            if ( $column.attr( 'data-css-classes' ) ) {
                $classes = $column.attr( 'data-css-classes' ).split( ' ' );
            }

            if ( $row.hasClass( 'grid' ) ) { // Refresh isotope
                if ( !$row.data( 'creative-preset' ) ) {
                    $.ajax( {
                        url: wolmart_elementor.ajax_url,
                        data: {
                            action: 'wolmart_load_creative_layout',
                            nonce: wolmart_elementor.wpnonce,
                            mode: $row.data( 'creative-mode' ),
                        },
                        type: 'post',
                        async: false,
                        success: function ( res ) {
                            if ( res ) {
                                $row.data( 'creative-preset', res );
                            }
                        }
                    } );
                }
                // Remove existing layout classes
                var cls = $obj.attr( 'class' );
                cls = cls.slice( 0, cls.indexOf( "grid-item" ) ) + cls.slice( cls.indexOf( "size-" ) );
                $obj.attr( 'class', cls );
                $obj.removeClass( 'size-small size-medium size-large e' );

                var preset = JSON.parse( $row.data( 'creative-preset' ) );
                var item_data = $column.data( 'creative-item' );
                var grid_item = {};

                if ( undefined == preset[ $obj.index() ] ) {
                    grid_item = { 'w': '1-4', 'w-l': '1-2', 'h': '1-3' };
                } else {
                    grid_item = preset[ $obj.index() ];
                }

                if ( undefined != item_data[ 'w' ] ) {
                    grid_item[ 'w' ] = grid_item[ 'w-l' ] = grid_item[ 'w-m' ] = grid_item[ 'w-s' ] = item_data[ 'w' ];
                }
                if ( undefined != item_data[ 'w-l' ] ) {
                    grid_item[ 'w-l' ] = grid_item[ 'w-m' ] = grid_item[ 'w-s' ] = item_data[ 'w-l' ];
                }
                if ( undefined != item_data[ 'w-m' ] ) {
                    grid_item[ 'w-m' ] = grid_item[ 'w-s' ] = item_data[ 'w-m' ];
                }
                if ( undefined != item_data[ 'h' ] && 'preset' != item_data[ 'h' ] ) {
                    if ( 'child' == item_data[ 'h' ] ) {
                        grid_item[ 'h' ] = '';
                    } else {
                        grid_item[ 'h' ] = item_data[ 'h' ];
                    }
                }
                if ( undefined != item_data[ 'h-l' ] && 'preset' != item_data[ 'h-l' ] ) {
                    if ( 'child' == item_data[ 'h-l' ] ) {
                        grid_item[ 'h-l' ] = '';
                    } else {
                        grid_item[ 'h-l' ] = item_data[ 'h-l' ];
                    }
                }
                if ( undefined != item_data[ 'h-m' ] && 'preset' != item_data[ 'h-m' ] ) {
                    if ( 'child' == item_data[ 'h-m' ] ) {
                        grid_item[ 'h-m' ] = '';
                    } else {
                        grid_item[ 'h-m' ] = item_data[ 'h-m' ];
                    }
                }

                var style = '<style>';
                Object.entries( grid_item ).forEach( function ( item ) {
                    if ( 'h' == item[ 0 ] || 'size' == item[ 0 ] || !Number( item[ 1 ] ) ) {
                        return;
                    }
                    if ( 100 % item[ 1 ] == 0 ) {
                        if ( 1 == item[ 1 ] ) {
                            grid_item[ item[ 0 ] ] = '1';
                        } else {
                            grid_item[ item[ 0 ] ] = '1-' + ( 100 / item[ 1 ] );
                        }
                    } else {
                        for ( var i = 1; i <= 100; ++i ) {
                            var val = item[ 1 ] * i;
                            var val_round = Math.round( val );
                            if ( Math.abs( Math.ceil( ( val - val_round ) * 100 ) / 100 ) <= 0.01 ) {
                                var g = gcd( 100, val_round );
                                var numer = val_round / g;
                                var deno = i * 100 / g;
                                grid_item[ item[ 0 ] ] = numer + '-' + deno;

                                // For Smooth Resizing of Isotope Layout
                                if ( 'w-l' == item[ 0 ] ) {
                                    style += '@media (max-width: 991px) {';
                                } else if ( 'w-m' == item[ 0 ] ) {
                                    style += '@media (max-width: 767px) {';
                                }

                                style += '.elementor-element-' + $row.closest( '.elementor-section' ).attr( 'data-id' ) + ' .grid-item.' + item[ 0 ] + '-' + numer + '-' + deno + '{flex:0 0 ' + ( numer * 100 / deno ).toFixed( 4 ) + '%;width:' + ( numer * 100 / deno ).toFixed( 4 ) + '%}';

                                if ( 'w-l' == item[ 0 ] || 'w-m' == item[ 0 ] ) {
                                    style += '}';
                                }
                                break;
                            }
                        }

                    }
                } )
                style += '</style>';
                $row.before( style );

                $obj.addClass( get_creative_class( grid_item ) );

                // Set Order Data
                $obj.attr( 'data-creative-order', ( undefined == $column.attr( 'data-creative-order' ) ? $obj.index() + 1 : $column.attr( 'data-creative-order' ) ) );
                $obj.attr( 'data-creative-order-lg', ( undefined == $column.attr( 'data-creative-order-lg' ) ? $obj.index() + 1 : $column.attr( 'data-creative-order-lg' ) ) );
                $obj.attr( 'data-creative-order-md', ( undefined == $column.attr( 'data-creative-order-md' ) ? $obj.index() + 1 : $column.attr( 'data-creative-order-md' ) ) );

                var layout = $row.data( 'creative-layout' );
                if ( !layout ) {
                    layout = [];
                }
                layout[ $obj.index() ] = grid_item;
                $row.data( 'creative-layout', layout );
                $row.find( '.grid-space' ).appendTo( $row );
                Object.setPrototypeOf( $obj.get( 0 ), HTMLElement.prototype );
                var timer = setTimeout( function () {
                    elementorFrontend.hooks.doAction( 'refresh_isotope_layout', timer, $row );
                }, 300 );
            }

            if ( 0 < $obj.find( '.slider-wrapper' ).length ) {
                $obj.find( '.elementor-widget-wrap > .elementor-background-overlay' ).remove();
            }
            this.completed && initSlider( $obj.find( '.slider-wrapper' ) ); // issue
            if ( $row.hasClass( 'slider-wrapper' ) ) { // Slider
                initSlider( $row );
            } else if ( $row.children( '.slider-wrapper' ).length ) {
                initSlider( $row.children( '.slider-wrapper' ) );
            } else if ( $wrapper.hasClass( 'tab' ) ) { // Tab
                var title = $column.data( 'tab-title' ) || wolmart_elementor.text_untitled;
                var content = $wrapper.children( '.tab-content' );

                // Add a new tab
                if ( !$obj.parent().hasClass( 'tab-content' ) ) {
                    content.append( $obj );
                }

                // Delete tab
                $wrapper.children( '.nav-tabs' ).children( 'li' ).each( function () {
                    var id = $( this ).attr( 'pane-id' );
                    $( '.elementor-column[data-id="' + id + '"]' ).length || $( this ).remove();
                } )

                //  Set columns' id from data-id
                $obj.add( $obj.siblings() ).each( function () {
                    var $col = $( this );
                    $col.data( 'id' ) && $col.attr( 'id', $col.data( 'id' ) );
                } )

                $obj.addClass( 'tab-pane' );
                var $links = $wrapper.children( 'ul.nav' );
                if ( $links.find( '[pane-id="' + $obj.data( 'id' ) + '"]' ).length ) {
                    $links.find( '[pane-id="' + $obj.data( 'id' ) + '"] a' ).html( title );
                } else {
                    $links.append( '<li class="nav-item" pane-id="' + $obj.data( 'id' ) + '"><a class="nav-link" data-toggle="tab" href="' + $obj.data( 'id' ) + '">' + title + '</a></li>' );
                }
                var $first = $wrapper.find( 'ul.nav > li:first-child > a' );
                if ( !$first.hasClass( 'active' ) && 0 == $wrapper.find( 'ul.nav .active' ).length ) {
                    $first.addClass( 'active' );
                    $first.closest( 'ul.nav' ).next( '.tab-content' ).find( '.tab-pane:first-child' ).addClass( 'active' );
                }
            } else if ( $row.hasClass( 'accordion' ) ) { // Accordion
                $obj.addClass( 'card' );
                var $header = $obj.children( '.card-header' ),
                    $body = $obj.children( '.card-body' );

                $body.attr( 'id', $obj.data( 'id' ) );

                var title = $column.data( 'accordion-title' ) || wolmart_elementor.text_untitled;
                $header.html( '<a href="' + $obj.data( 'id' ) + '"  class="collapse"><i class="' + $body.attr( 'data-accordion-icon' ) + '"></i><span class="title">' + title + '</span><span class="toggle-icon closed"><i class="' + $row.data( 'toggle-icon' ) + '"></i></span><span class="toggle-icon opened"><i class="' + $row.data( 'toggle-active-icon' ) + '"></i></span></a>' ); // updated
            } else if ( $row.hasClass( 'banner' ) ) {  // Column Banner Layer
                var banner_class = $column.data( 'banner-class' );
                if ( -1 == $classes.indexOf( 't-c' ) ) {
                    $obj.removeClass( 't-c' );
                }
                if ( -1 == $classes.indexOf( 't-m' ) ) {
                    $obj.removeClass( 't-m' );
                }
                if ( -1 == $classes.indexOf( 't-mc' ) ) {
                    $obj.removeClass( 't-mc' );
                }
                $obj.removeClass( 'banner-content' );
                if ( banner_class ) {
                    $obj.addClass( banner_class );
                }
                // $row.hasClass('parallax') && Wolmart.parallax($row);
            }
        },
        initWidgetAdvanced: function ( $obj ) {

            var $parent = $obj.parent();
            if ( $parent.hasClass( 'slider-wrapper' ) ) {
                initSlider( $parent );
            } else if ( $parent.hasClass( 'slider-container' ) && $obj.siblings( '.slider-wrapper' ).length ) {
                var $slider = $obj.siblings( '.slider-wrapper' );
                $obj.remove().appendTo( $slider );
                initSlider( $slider );
            }

            var widget_settings = this.widgetEditorSettings( $obj.data( 'id' ) );

            $obj.addClass( 'wolmart-motion-effect-widget wolmart-scroll-effect-widget' );
            $obj.attr( 'data-wolmart-scroll-effect-settings', JSON.stringify( widget_settings.scroll ) );

            if ( Object.keys( widget_settings.scroll ).length ) {
                if ( wolmart_elementor.assets_url ) {

                    if ( typeof skrollr != 'undefined' ) {
                        Wolmart.initAdvancedMotions( $obj, 'destroy' );
                        Wolmart.initAdvancedMotions( $obj, 'init' );
                    } else {
                        $( document.createElement( 'script' ) ).attr( 'id', 'skrollr' ).appendTo( 'body' ).attr( 'src', wolmart_elementor.assets_url + '/assets/js/skrollr.min.js' ).on( 'load', function () {
                            Wolmart.initAdvancedMotions( $obj, 'destroy' );
                            Wolmart.initAdvancedMotions( $obj, 'init' );
                        } );
                    }
                }
            } else {
                Wolmart.initAdvancedMotions( $obj, 'destroy' );
            }

            if ( Object.keys( widget_settings.track ).length ) {

                $obj.addClass( 'wolmart-motion-effect-widget wolmart-mouse-effect-widget floating-wrapper' );
                $obj.attr( 'data-toggle', 'floating' );
                $obj.attr( 'data-options', JSON.stringify( widget_settings.track ) );
                $obj.attr( 'data-child-depth', widget_settings.track.speed );

                if ( wolmart_elementor.assets_url ) {
                    $( document.createElement( 'script' ) ).attr( 'id', 'jquery-floating-parallax' ).appendTo( 'body' ).attr( 'src', wolmart_elementor.assets_url + '/assets/js/jquery.parallax.min.js' ).on( 'load', function () {
                        Wolmart.initFloatingElements( $obj );
                    } );
                }
            } else {
                if ( $obj.data( 'parallax' ) ) {
                    $obj.parallax( 'disable' );
                    $obj.removeData( 'parallax' );
                    $obj.removeData( 'options' );
                }
            }
        },
        widgetEditorSettings: function ( widgetId ) {
            var editorElements = null,
                widgetData = {};

            if ( !window.elementor.hasOwnProperty( 'elements' ) ) {
                return false;
            }

            editorElements = window.elementor.elements;

            if ( !editorElements.models ) {
                return false;
            }

            $.each( editorElements.models, function ( index, obj ) {

                $.each( obj.attributes.elements.models, function ( index, obj ) {

                    $.each( obj.attributes.elements.models, function ( index, obj ) {

                        if ( widgetId == obj.id ) {
                            widgetData = obj.attributes.settings.attributes;
                            return;
                        }

                        $.each( obj.attributes.elements.models, function ( index, obj ) {

                            if ( widgetId == obj.id ) {
                                widgetData = obj.attributes.settings.attributes;
                                return;
                            }

                            $.each( obj.attributes.elements.models, function ( index, obj ) {

                                if ( widgetId == obj.id ) {
                                    widgetData = obj.attributes.settings.attributes;
                                }

                            } );

                        } );
                    } );

                } );

            } );

            var scrolls = {};
            if ( 'yes' == widgetData[ 'wolmart_advanced_scroll_effect' ] && widgetData[ 'wolmart_scroll_effects' ].length ) {
                $.each( widgetData[ 'wolmart_scroll_effects' ].models, function ( index, model ) {
                    var effect = model.attributes,
                        scroll_effect = effect[ 'scroll_effect' ];

                    scrolls[ scroll_effect ] = {};

                    if ( 'Vertical' == scroll_effect ) {
                        scrolls[ scroll_effect ].direction = effect[ 'v_direction' ];
                    } else if ( 'Horizontal' == scroll_effect || 'Rotate' == scroll_effect ) {
                        scrolls[ scroll_effect ].direction = effect[ 'h_direction' ];
                    } else if ( 'Transparency' == scroll_effect ) {
                        scrolls[ scroll_effect ].direction = effect[ 't_direction' ];
                    } else if ( 'Scale' == scroll_effect ) {
                        scrolls[ scroll_effect ].direction = effect[ 's_direction' ];
                    }
                    scrolls[ scroll_effect ].speed = effect[ 'speed' ][ 'size' ] ? effect[ 'speed' ][ 'size' ] : 10;
                    scrolls[ 'viewport' ] = widgetData[ 'wolmart_advanced_scroll_viewport' ];
                } );
            }

            var tracks = {};
            if ( 'yes' == widgetData[ 'wolmart_advanced_mouse_effect' ] ) {
                if ( 'yes' == widgetData[ 'track_relative' ] ) {
                    tracks.relativeInput = true;
                    tracks.clipRelativeInput = true;
                } else {
                    tracks.relativeInput = false;
                    tracks.clipRelativeInput = false;
                }
                if ( 'direct' == widgetData[ 'track_direction' ] ) {
                    tracks.invertX = false;
                    tracks.invertY = false;
                } else {
                    tracks.invertX = true;
                    tracks.invertY = true;
                }
                tracks.speed = widgetData[ 'track_speed' ][ 'size' ] ? widgetData[ 'track_speed' ][ 'size' ] : 1;
            }

            return { scroll: scrolls, track: tracks };
        },
        initGlobal: function () {
            elementor.channels.data.on( 'wolmart_elementor_element_after_add', function ( e ) {
                var $obj = $( '[data-id="' + e.id + '"]' ),
                    $row = $obj.closest( '.elementor-row' ),
                    $column = 'widget' == e.elType ? $obj.closest( '.elementor-widget-wrap' ) : false;
                if ( 'widget' == e.elType && $column.hasClass( 'slider-wrapper' ) ) {
                    initSlider( $column );
                } else if ( 'column' == e.elType && $row.data( 'slider' ) ) {
                    $row.data( 'slider' ).destroy();
                    $row.removeData( 'slider' );
                } else if ( 'column' == e.elType && $row.data( 'isotope' ) ) {
                    $row.data( 'isotope' ) && $row.isotope( 'destroy' );
                }
            } );

            elementor.channels.data.on( 'wolmart_elementor_element_before_delete', function ( e ) {
                var $obj = $( '[data-id="' + e.id + '"]' ),
                    $row = $obj.closest( '.elementor-row' ),
                    $column = 'widget' == e.attributes.elType ? $obj.closest( '.elementor-widget-wrap' ) : false;
                if ( 'widget' == e.attributes.elType && $column.hasClass( 'slider-wrapper' ) ) {
                    initSlider( $column );
                } else if ( 'column' == e.attributes.elType && $row.data( 'slider' ) ) {
                    var pos = $obj.parent( '.slider-slide:not(.slider-slide-duplicate)' ).index() - ( $row.find( '.slider-slide.slider-slide-duplicate' ).length / 2 );
                    $row.data( 'slider' ).removeSlide( pos );
                } else if ( 'column' == e.attributes.elType && $row.data( 'isotope' ) ) {
                    $row.isotope( 'remove', $obj ).isotope( 'layout' );
                }
            } );

            elementorFrontend.hooks.addAction( 'refresh_isotope_layout', function ( timer, $selector, force ) {
                if ( undefined == force ) {
                    force = false;
                }

                if ( timer ) {
                    clearTimeout( timer );
                }

                if ( undefined == $selector ) {
                    $selector = $( '.elementor-element-editable' ).closest( '.grid' );
                }

                $selector.siblings( 'style' ).remove();
                $selector.parent().prepend( get_creative_grid_item_css(
                    $selector.closest( '.elementor-section' ).data( 'id' ),
                    $selector.data( 'creative-layout' ),
                    $selector.data( 'creative-height' ),
                    $selector.data( 'creative-height-ratio' ) ) );

                if ( true === force ) {
                    $selector.data( 'isotope' ) && $selector.isotope( 'destroy' );
                    Wolmart.isotopes( $selector );
                } else {
                    if ( $selector.data( 'isotope' ) ) {
                        $selector.removeAttr( 'data-current-break' );
                        $selector.isotope( 'reloadItems' );
                        $selector.isotope( 'layout' );
                    } else {
                        Wolmart.isotopes( $selector );
                    }
                }
                var slider = $selector.find( '.slider-wrapper' ).data( slider );
                slider && slider.slider && slider.slider.update();
                $( window ).trigger( 'resize' );
            } );
        }
    };

    /**
     * Setup WolmartElementorPreview
     */
    $( window ).on( 'load', function () {
        if ( typeof elementorFrontend != 'undefined' && typeof Wolmart != 'undefined' ) {
            var componentInit = function () {
                var deferred = $.Deferred();
                if ( elementorFrontend.hooks ) {
                    WolmartElementorPreview.init();
                    deferred.resolve();
                } else {
                    elementorFrontend.on( 'components:init', function () {
                        WolmartElementorPreview.init();
                        deferred.resolve();
                    } );
                }
                return deferred.promise();
            }();

            // check if current template is popup   
            if ( $( 'body' ).hasClass( 'wolmart_popup_template' ) ) {
                var $edit_area = $( 'main [data-elementor-id]' ),
                    id = $edit_area.data( 'elementor-id' );
                $edit_area.parent().prepend( '<div class="mfp-bg mfp-fade mfp-wolmart-' + id + ' mfp-ready"></div>' );
                $edit_area.wrap( '<div class="mfp-wrap mfp-close-btn-in mfp-auto-cursor mfp-fade mfp-wolmart mfp-wolmart-' + id + ' mfp-ready" tabindex="-1" style="overflow: hidden auto;"><div class="mfp-container mfp-inline-holder"><div class="mfp-content"><div id="wolmart-popup-' + id + '" class="popup mfp-fade"><div class="wolmart-popup-content"></div></div></div></div></div>' )
            }
            var onComplete = function () {
                var deferred = $.Deferred();
                $( window ).on( 'wolmart_complete', function () {
                    deferred.resolve();
                } );
                return deferred.promise();
            }();

            $.when( componentInit, onComplete ).done(
                function ( e ) {
                    if ( elementorFrontend.hooks ) {
                        WolmartElementorPreview.onComplete();
                    }
                }
            );
        }
    } );
} )( jQuery );