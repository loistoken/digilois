/**
 * Javascript Library for Critical Wizard Admin
 * 
 * Generate Critical CSS
 * 
 * @author     D-THEMES
 * @since      1.2.0
 * @package    Wolmart Wordpress Framework
 * @subpackage Core
 */
'use strict';

window.themeAdmin = window.themeAdmin || {};

( function ( $ ) {
    /**
     * @since 1.2.0
     */
    var criticalWizard = {
        $form: $( '#wolmart-critical-form' ),
        $tableForm: $( '#wolmart-critical-table-form' ),
        $progressBar: $( '.wolmart-progress-bar' ),
        criticalDone: 0,
        criticalTodo: 0,
        init: function () {
            // Init select 2
            var $selectParticular = $( '#wolmart-select-particular' );
            $selectParticular.select2( {
                placeholder: $selectParticular.attr( 'data-placeholder' ),
            } );
            // Page Type On Change
            $( '#wolmart-critical-page' ).on( 'change', function () {
                if ( $( this ).val() == 'individual_pages' ) {
                    $( 'label[for=wolmart-select-particular]' ).removeClass( 'disabled' );
                } else {
                    $( 'label[for=wolmart-select-particular]' ).addClass( 'disabled' );
                }
            } );
            if ( $( '.temp-iframe' ).length == 0 ) {
                $( 'body' ).append( '<iframe class="temp-iframe" style="max-width: none; max-height: none; border: 0px;" aria-hidden="true" sandbox="allow-same-origin "></iframe>' );
            }
            this.$form.on( 'submit', function ( e ) {
                e.preventDefault();
                themeAdmin.criticalWizard.$progressBar.css( { width: '0' } );
                themeAdmin.criticalWizard.$progressBar.removeClass( 'failed' );
                $( this ).find( 'button' ).addClass( 'disabled' ).html( '<i class="fas fa-spinner fa-spin"></i> ' + wp.i18n.__( 'Generating Critical', 'wolmart-core' ) );
                $.post(
                    ajaxurl,
                    themeAdmin.criticalWizard.$form.serialize(),
                    async function ( response ) {
                        if ( typeof response.data == 'object' ) {
                            var urls = response.data;
                            var length = Object.keys( urls ).length;
                            if ( length == 0 ) return;
                            // 10% progress bar
                            themeAdmin.criticalWizard.$progressBar.css( { width: '10%' } );
                            // Initialize 
                            themeAdmin.criticalWizard.criticalDone = 0;
                            themeAdmin.criticalWizard.criticalTodo = length;
                            var urlKeys = Object.keys( urls );
                            for ( var i = 0; i < urlKeys.length; i++ ) {
                                var id = urlKeys[ i ];
                                var pageCriticalCss = {};
                                // desktop
                                await themeAdmin.criticalCss.main( urls[ id ].desktop );
                                pageCriticalCss[ 'desktop' ] = {
                                    css: themeAdmin.criticalCss.resultCriticalCss,
                                    preload: themeAdmin.criticalCss.resultPreload,
                                };
                                // mobile
                                await themeAdmin.criticalCss.main( urls[ id ].mobile, 'mobile', true );
                                pageCriticalCss[ 'mobile' ] = {
                                    css: themeAdmin.criticalCss.resultCriticalCss,
                                    preload: themeAdmin.criticalCss.resultPreload,
                                };

                                // to Server
                                await $.post(
                                    ajaxurl,
                                    {
                                        action: 'wolmart_save_critical',
                                        id: id,
                                        pageCriticalCss: pageCriticalCss,
                                        _wpnonce: themeAdmin.criticalWizard.$tableForm.data( 'nonce' )
                                    },
                                    function ( response ) {
                                        console.log( response );
                                    }
                                );
                            }
                            // to Server
                            await $.post(
                                ajaxurl,
                                {
                                    action: 'wolmart_clear_merged_css',
                                    _wpnonce: themeAdmin.criticalWizard.$tableForm.data( 'nonce' )
                                },
                                function ( response ) {
                                }
                            );
                            themeAdmin.criticalWizard.$progressBar.css( { width: '101%' } ); // because can't show progress rounded.                            
                        }
                        location.reload( true );
                        // themeAdmin.criticalWizard.$form.find( 'button' ).removeClass( 'disabled' ).html( wp.i18n.__( 'Generating Critical CSS', 'wolmart-core' ) );
                    }
                );
            } );
            this.$tableForm.on( 'click', '.wolmart-recompile-row', function ( e ) {
                e.preventDefault();
                var $this = $( this );
                if ( $this.hasClass( 'disabled' ) ) {
                    return false;
                }
                themeAdmin.criticalWizard.$progressBar.css( { width: '0' } );
                themeAdmin.criticalWizard.$progressBar.removeClass( 'failed' );
                themeAdmin.criticalWizard.$tableForm.find( '.button' ).addClass( 'disabled' );
                $this.html( '<i class="fas fa-spinner fa-spin"></i> ' + wp.i18n.__( 'Recompile', 'wolmart-core' ) );
                $.post(
                    ajaxurl,
                    {
                        action: 'wolmart_critical_get_page',
                        wolmart_critical_page: 'individual_pages',
                        wolmart_select_particular: $this.closest( 'tr' ).attr( 'data-page-id' ),
                        wolmart_critical_nonce: themeAdmin.criticalWizard.$tableForm.attr( 'data-nonce' ),
                    },
                    async function ( response ) {
                        if ( typeof response.data == 'object' ) {
                            var urls = response.data;
                            var length = Object.keys( urls ).length;
                            if ( length == 0 ) return;
                            // 10% progress bar
                            themeAdmin.criticalWizard.$progressBar.css( { width: '10%' } );
                            // Initialize 
                            themeAdmin.criticalWizard.criticalDone = 0;
                            themeAdmin.criticalWizard.criticalTodo = length;

                            var pageCriticalCss = {};
                            var id = Object.keys( urls )[ 0 ];
                            // desktop
                            await themeAdmin.criticalCss.main( urls[ id ].desktop );
                            pageCriticalCss[ 'desktop' ] = {
                                css: themeAdmin.criticalCss.resultCriticalCss,
                                preload: themeAdmin.criticalCss.resultPreload,
                            };
                            // mobile
                            await themeAdmin.criticalCss.main( urls[ id ].mobile, 'mobile', true );
                            pageCriticalCss[ 'mobile' ] = {
                                css: themeAdmin.criticalCss.resultCriticalCss,
                                preload: themeAdmin.criticalCss.resultPreload,
                            };

                            // to Server
                            await $.post(
                                ajaxurl,
                                {
                                    action: 'wolmart_save_critical',
                                    id: id,
                                    pageCriticalCss: pageCriticalCss,
                                    _wpnonce: themeAdmin.criticalWizard.$tableForm.data( 'nonce' )
                                },
                                function ( response ) {
                                    console.log( response );
                                }
                            );
                            await $.post(
                                ajaxurl,
                                {
                                    action: 'wolmart_clear_merged_css',
                                    _wpnonce: themeAdmin.criticalWizard.$tableForm.data( 'nonce' )
                                },
                                function ( response ) {
                                }
                            );
                            themeAdmin.criticalWizard.$progressBar.css( { width: '101%' } ); // because can't show progress rounded.   
                        }
                        location.reload( true );
                        // themeAdmin.criticalWizard.$form.find( 'button' ).removeClass( 'disabled' ).html( wp.i18n.__( 'Generating Critical CSS', 'wolmart-core' ) );
                    }
                );
            } );
            this.$tableForm.on( 'submit', function ( e ) {

                var $this = $( this );
                if ( $this.find( '#bulk-action-selector-top' ).val() == 'wolmart_bulk_delete_critical' ) return;
                e.preventDefault();
                if ( $this.find( '#bulk-action-selector-top' ).val() == '-1' ) return;
                // regenerate
                themeAdmin.criticalWizard.$tableForm.find( '.button' ).addClass( 'disabled' );
                $this.find( '.button.action' ).html( '<i class="fas fa-spinner fa-spin"></i> ' + wp.i18n.__( 'Apply', 'wolmart-core' ) );

                themeAdmin.criticalWizard.$progressBar.css( { width: '0' } );
                themeAdmin.criticalWizard.$progressBar.removeClass( 'failed' );
                var recompilePages = [];
                $this.find( 'tbody tr' ).each( function () {
                    if ( $( this ).find( 'input[type="checkbox"]' ).is( ':checked' ) ) {
                        recompilePages.push( $( this ).attr( 'data-page-id' ) );
                    }
                } );
                $.post(
                    ajaxurl,
                    {
                        action: 'wolmart_critical_get_page',
                        wolmart_critical_page: 'individual_pages',
                        'wolmart_select_particular[]': recompilePages,
                        wolmart_critical_nonce: $this.attr( 'data-nonce' ),
                    },
                    async function ( response ) {
                        if ( typeof response.data == 'object' ) {
                            var urls = response.data;
                            var length = Object.keys( urls ).length;
                            if ( length == 0 ) return;
                            // 10% progress bar
                            themeAdmin.criticalWizard.$progressBar.css( { width: '10%' } );
                            // Initialize 
                            themeAdmin.criticalWizard.criticalDone = 0;
                            themeAdmin.criticalWizard.criticalTodo = length;
                            var urlKeys = Object.keys( urls );
                            for ( var i = 0; i < urlKeys.length; i++ ) {
                                var id = urlKeys[ i ];
                                var pageCriticalCss = {};
                                // desktop
                                await themeAdmin.criticalCss.main( urls[ id ].desktop );
                                pageCriticalCss[ 'desktop' ] = {
                                    css: themeAdmin.criticalCss.resultCriticalCss,
                                    preload: themeAdmin.criticalCss.resultPreload,
                                };
                                // mobile
                                await themeAdmin.criticalCss.main( urls[ id ].mobile, 'mobile', true );
                                pageCriticalCss[ 'mobile' ] = {
                                    css: themeAdmin.criticalCss.resultCriticalCss,
                                    preload: themeAdmin.criticalCss.resultPreload,
                                };
                                // to Server
                                await $.post(
                                    ajaxurl,
                                    {
                                        action: 'wolmart_save_critical',
                                        id: id,
                                        pageCriticalCss: pageCriticalCss,
                                        _wpnonce: themeAdmin.criticalWizard.$tableForm.data( 'nonce' )
                                    },
                                    function ( response ) {
                                        console.log( response );
                                    }
                                );
                            }
                            await $.post(
                                ajaxurl,
                                {
                                    action: 'wolmart_clear_merged_css',
                                    _wpnonce: themeAdmin.criticalWizard.$tableForm.data( 'nonce' )
                                },
                                function ( response ) {
                                }
                            );
                            themeAdmin.criticalWizard.$progressBar.css( { width: '101%' } ); // because can't show progress rounded.   
                        }
                        location.reload( true );
                        // themeAdmin.criticalWizard.$form.find( 'button' ).removeClass( 'disabled' ).html( wp.i18n.__( 'Generating Critical CSS', 'wolmart-core' ) );
                    }
                );

            } );
        }
    }
    /**
     * Setup Critical Wizard
     * 
     * @since 1.2.0
     */
    themeAdmin.criticalWizard = criticalWizard;
    $( document ).ready( function () {
        criticalWizard.init();
    } );
} )( window.jQuery );