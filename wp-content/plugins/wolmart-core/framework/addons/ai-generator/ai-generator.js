/**
 * Generate text by GPT-3
 * 
 * @since 1.5.0
 */
jQuery( function( $ ) {
    'use strict';

	$( 'body' ).on( 'click', '.wolmart-dialog-wrapper .btn-yes', function (e) {
		e.preventDefault();
		$( '#ai-output' ).trigger( 'select' );
        document.execCommand( 'copy' );
		$( this ).html( wp.i18n.__( 'Copied', 'wolmart-core' ) );
	} );

	$( 'body' ).on( 'click', '#generate_btn, .ai-plugin-gen', function ( e ) {
		e.preventDefault();
		var generateType = $( this ).attr( 'name' );
		if ( 'undefined' != typeof wolmart_admin_vars && 'undefined' != typeof wolmart_admin_vars.ai_key ) {
			var __ = wp.i18n.__,
				aiSettings = {
					'description': { 'type': 'Description', 'max_tokens': 2048, 'temperature': 0.9, 'prompt': __( 'Please write a %1$s description about the "%2$s". %3$s %4$s', 'wolmart-core' ),'addQuery': __( 'Write at least 5 paragraphs.', 'wolmart-core' ) },
					'excerpt': { 'type': 'Excerpt', 'max_tokens': 64, 'temperature': 0.1, 'prompt': __( 'Please write a %1$s short excerpt about the "%2$s". %3$s %4$s', 'wolmart-core' ),'addQuery': __( 'The excerpt must be between 55 and 75 characters.', 'wolmart-core' ) },
					'meta_desc': { 'type': 'Meta Description for SEO', 'max_tokens': 265, 'temperature': 0.3, 'prompt': __( 'Please write a SEO friendly meta description for the %1$s "%2$s". %3$s %4$s', 'wolmart-core' ),'addQuery': __( 'The description must be between 105 and 140 characters.', 'wolmart-core' ) },
					'meta_title': { 'type': 'Meta Title for SEO', 'max_tokens': 64, 'temperature': 0.6, 'prompt': __( 'Please write a SEO friendly meta title for the %1$s "%2$s". %3$s %4$s', 'wolmart-core' ),'addQuery': __( 'The title must be between 40 and 60 characters.', 'wolmart-core' ) },
					'meta_key': { 'type': 'Meta Keywords for SEO', 'max_tokens': 265, 'temperature': 0.6, 'prompt': __( 'Please write a SEO friendly meta keywords for the %1$s "%2$s". %3$s %4$s', 'wolmart-core' ),'addQuery': __( 'Write at least 10 words.', 'wolmart-core' ) },
					'outline': { 'type': 'Outline', 'max_tokens': 2048, 'temperature': 0.9, 'prompt': __( 'Please write a %1$s outline about the "%2$s". %3$s %4$s', 'wolmart-core' ),'addQuery': __( 'Outline type is a alphanumeric outline.', 'wolmart-core' ) },
				};

			var promptTopic = $( '#prompt_topic' ).length ? $( '#prompt_topic' ).val() : '' ,
			contentType = $( '#ai_content_type' ).length ? $( '#ai_content_type' ).val() : '',
			writeStyle = ( $( '#ai_write_style' ).length && '' != $( '#ai_write_style' ).val() ) ? 'Writing Style: ' + $( '#ai_write_style' ).val() + '.' : '',
			postType = wolmart_admin_vars.post_type,
			addQuery = '',
			$userWord = $( '#user_word' );

			if ( '' == promptTopic.trim() ) {
				promptTopic = $( 'input#title' ).length ? $( 'input#title' ).val() : $( 'h1.editor-post-title' ).text();
			}

			// Initialize the options for generating Meta Description in Seo plugin
			if ( 'generate_btn' != generateType ) {
				writeStyle = '';
				contentType = 'meta_desc';
			}

			// If the title is empty
			if ( '' == promptTopic.trim() ) {
				window.alert( __( 'Please input the title.', 'wolmart-core' ) );
				return;
			}

			// If the generate type is empty
			if ( '' == contentType ) {
				window.alert( __( 'Please select the Generate Type.', 'wolmart-core' ) );
				return;
			}

			if ( $userWord.length && $userWord.val().trim().length && 'ai_generate' == generateType ) {
				addQuery = $userWord.val().trim();
				if ( '.' != addQuery.slice( -1 ) && '。' != addQuery.slice( -1 ) ) {
					addQuery += '.';
				}
			} else {
				addQuery = aiSettings[ contentType ].addQuery;
			}
			var $dialog = $( '.wolmart-dialog-wrapper' );
			// Add Output Dialog
			WolmartAdmin.prompt.showDialog( {
				title: wp.i18n.__( '%1$s Generating', 'wolmart-core' ).replace( '%1$s', aiSettings[ contentType ].type ),
				content: wp.i18n.__( '<textarea class="output" id="ai-output"></textarea><span class="loading"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40px" height="40px" viewBox="0 0 40 40" version="1.1"><g><path style="fill:#333;" d="M 31.066406 4.726562 C 33.964844 4.726562 36.316406 7.058594 36.316406 9.933594 C 36.316406 12.808594 33.964844 15.140625 31.066406 15.140625 C 28.167969 15.140625 25.816406 12.808594 25.816406 9.933594 C 25.816406 7.058594 28.167969 4.726562 31.066406 4.726562 Z M 35.824219 16.949219 C 33.460938 16.949219 31.546875 18.851562 31.546875 21.191406 C 31.546875 23.535156 33.460938 25.4375 35.824219 25.4375 C 38.1875 25.4375 40.105469 23.535156 40.105469 21.191406 C 40.101562 18.851562 38.1875 16.949219 35.824219 16.949219 Z M 30.863281 29.238281 C 29.214844 29.238281 27.875 30.5625 27.875 32.199219 C 27.875 33.835938 29.214844 35.164062 30.863281 35.164062 C 32.511719 35.164062 33.851562 33.835938 33.851562 32.199219 C 33.851562 30.5625 32.511719 29.238281 30.863281 29.238281 Z M 19.433594 34.03125 C 17.785156 34.03125 16.445312 35.359375 16.445312 36.996094 C 16.445312 38.632812 17.785156 39.960938 19.433594 39.960938 C 21.085938 39.960938 22.421875 38.632812 22.421875 36.996094 C 22.421875 35.359375 21.085938 34.03125 19.433594 34.03125 Z M 7.753906 29.546875 C 6.207031 29.546875 4.953125 30.792969 4.953125 32.324219 C 4.953125 33.859375 6.207031 35.101562 7.753906 35.101562 C 9.300781 35.101562 10.554688 33.859375 10.554688 32.324219 C 10.554688 30.792969 9.300781 29.546875 7.753906 29.546875 Z M 2.980469 17.84375 C 1.335938 17.84375 0 19.167969 0 20.800781 C 0 22.433594 1.335938 23.757812 2.980469 23.757812 C 4.628906 23.757812 5.964844 22.433594 5.964844 20.800781 C 5.964844 19.167969 4.628906 17.84375 2.980469 17.84375 Z M 7.753906 5.535156 C 5.671875 5.535156 3.980469 7.214844 3.980469 9.28125 C 3.980469 11.347656 5.671875 13.019531 7.753906 13.019531 C 9.839844 13.019531 11.527344 11.347656 11.527344 9.28125 C 11.527344 7.214844 9.839844 5.535156 7.753906 5.535156 Z M 19.457031 0 C 16.949219 0 14.914062 2.019531 14.914062 4.503906 C 14.914062 6.992188 16.949219 9.011719 19.457031 9.011719 C 21.964844 9.011719 24 6.992188 24 4.503906 C 24 2.019531 21.964844 0 19.457031 0 Z M 19.457031 0 "/></g></svg></span>', 'wolmart-core' ),
				closeOnOverlay: false,
				actions: [
					{ title: wp.i18n.__( 'Copy to Clipboard', 'wolmart-core' ), noClose: true,	},
					{ title: wp.i18n.__( 'Close', 'wolmart-core' )	}
				]
			} );

			if ( ! $dialog.length ) {
				// The dialog exists
				$dialog = $( '.wolmart-dialog-wrapper' );
			} else {
				$dialog.removeClass( 'complete' );
			}

			var $outText = $dialog.find( '#ai-output' ),
				data = {
				model: "text-davinci-003",
				prompt: aiSettings[ contentType ].prompt.replace( '%1$s', postType ).replace( '%2$s', promptTopic ).replace( '%3$s', addQuery ).replace( '%4$s', writeStyle ).trim(),
				max_tokens: aiSettings[ contentType ].max_tokens,
				temperature: aiSettings[ contentType ].temperature,
				top_p: 1.0,
			},
			aiHttp = new XMLHttpRequest();
			aiHttp.open( "POST", "https://api.openai.com/v1/completions" );
			aiHttp.setRequestHeader( "Accept", "application/json" );
			aiHttp.setRequestHeader( "Content-Type", "application/json" );
			aiHttp.setRequestHeader( "timeout", "20000" );
			aiHttp.setRequestHeader( "Authorization", "Bearer " + wolmart_admin_vars.ai_key );

			aiHttp.onreadystatechange = function() {
				if ( aiHttp.readyState == 4 && aiHttp.status == 200 ) {
					var response = JSON.parse( aiHttp.response );
					if ( 'undefined' != typeof response[ 'choices' ] && 'undefined' != typeof response[ 'choices' ][0] ) {
						var responseText = response[ 'choices' ][0]['text'].trim();
						$dialog.addClass( 'complete' );
						if ( '' == responseText ) {
							$outText.val( __( 'Generate Failed!\nThere is a problem with your prompt.\n\nFor more information about creating a prompt, please visit the following URL.\n\nurl', 'wolmart-core' ) );
						} else {
							$outText.val( responseText );
						}
					}
				} else if ( 'undefined' != typeof aiHttp.response && null !== aiHttp.response.match( 'error' ) ) {
					var response = JSON.parse( aiHttp.response ),
					errorMessage = response['error']['message'];
					if ( errorMessage.match( 'API key provided(: .*)\.' ) ) {
						errorMessage = __( 'Incorrect API key provided.', 'wolmart-core' );
					}
					$dialog.addClass( 'complete' );
					$outText.val( __( 'Error: %s', 'wolmart-core' ).replace( '%s', errorMessage ) );
				}
			}

			// Timeout
			aiHttp.ontimeout = function() {
				$dialog.addClass( 'complete' );
				$outText.val( __( 'Request time is out.', 'wolmart-core' ) );
			};
			aiHttp.send( JSON.stringify( data ) );
			
			// Error
			aiHttp.onerror = function() {
				$dialog.addClass( 'complete' );
				$outText.val( __( 'Request Failed.', 'wolmart-core' ) );
			};
		}
	})


	// Insert Auto Generator Button
	var insertGenerator = function ( plugin, $inputPlace ) {
		if ( $inputPlace.length ) {
			$inputPlace.after( '<div class="ai-plugin-gen components-button is-primary" name="' + plugin + '-seo"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="17px" height="17px" viewBox="0 0 17 17" version="1.1"><g><path style="fill:#ffffffcc" d="M 8.136719 13.015625 C 5.660156 13.015625 3.644531 11.050781 3.644531 8.644531 C 3.644531 6.242188 5.660156 4.273438 8.136719 4.273438 C 9.882812 4.273438 11.390625 5.246094 12.144531 6.679688 L 14.546875 6.679688 C 13.941406 5.222656 12.675781 4.03125 11.050781 3.449219 C 10.5625 3.230469 9.882812 3.085938 9.105469 3.035156 C 8.984375 3.035156 8.863281 3.035156 8.765625 3.035156 C 8.765625 3.035156 8.742188 3.035156 8.742188 3.035156 C 8.71875 3.035156 8.695312 3.035156 8.671875 3.035156 C 8.621094 3.035156 8.574219 3.035156 8.523438 3.035156 C 8.476562 3.035156 8.453125 3.035156 8.402344 3.035156 C 5.320312 3.035156 2.816406 5.660156 2.816406 8.621094 C 2.816406 11.585938 5.320312 13.964844 8.402344 13.964844 C 10.128906 13.964844 11.707031 13.1875 12.726562 11.996094 L 11.027344 11.996094 C 10.222656 12.652344 9.253906 13.015625 8.136719 13.015625 Z M 8.136719 13.015625 "/><path style=" fill:#ffffffcc" d="M 12.53125 7.40625 L 11.460938 10.371094 L 10.492188 10.371094 L 11.535156 7.40625 L 9.496094 7.40625 L 8.425781 10.371094 L 7.429688 10.371094 L 8.5 7.40625 L 6.4375 7.40625 L 5.390625 10.371094 C 5.34375 10.492188 5.320312 10.589844 5.320312 10.6875 C 5.320312 11.074219 5.609375 11.292969 6.167969 11.292969 L 7.1875 11.292969 C 7.722656 11.292969 8.113281 11.121094 8.378906 10.78125 C 8.425781 11.121094 8.71875 11.292969 9.230469 11.292969 L 12.144531 11.292969 C 12.796875 11.292969 13.285156 10.976562 13.550781 10.371094 L 14.570312 7.40625 Z M 12.53125 7.40625 "/></g></svg>' + wp.i18n.__( 'AI Generate', 'wolmart-core' ) + '</div>' );
		}
	};

	/**
	 * Generate Meta Description for Plugins - Yoast Seo
	 * 
	 * @since 1.5.0
	 */
	$( window ).on( 'YoastSEO:ready', function () {
		var $metaWrapper = $( '#yoast-google-preview-description-metabox' ).closest( '.yst-replacevar' );
		if ( $metaWrapper.length ) {
			insertGenerator( 'yoast', $metaWrapper.find( 'button' ) );
		}
		// Collapse Meta Tab
		$( 'body' ).on( 'click', '#yoast-snippet-editor-metabox', function (e) {
			if ( 'true' == $( this ).attr( 'aria-expanded' ) ) {
				setTimeout( function () {
					var $metaWrapper = $( '#yoast-google-preview-description-metabox' ).closest( '.yst-replacevar' );
					insertGenerator( 'yoast', $metaWrapper.find( 'button' ) );	
				}, 3000 );
			}
		} );
	})
	
	/**
	 * Generate Meta Description for Plugins - All In One, RankMath Seo
	 * 
	 * @since 1.5.0
	 */
	$( document ).ready( function ( e ) {
		// All In One Seo Plugin
		if ( window.aioseo ) {
			var $inputPlace = $( 'body' ).find( '.aioseo-post-general #aioseo-post-settings-meta-description-row .add-tags .aioseo-view-all-tags' );
			// Insert AI Button
			insertGenerator( 'aio', $inputPlace );
			$( 'body' ).on( 'click', '.aioseo-app > .aioseo-tabs .md-tabs-navigation > button:first-child', function (e) {
				setTimeout( function () {
					var $inputPlace = $( 'body' ).find( '.aioseo-post-general #aioseo-post-settings-meta-description-row .add-tags .aioseo-view-all-tags' );
					insertGenerator( 'aio', $inputPlace );	
				}, 3000 );
			} );
			$( 'body' ).on( 'click', '#aioseo-post-settings-sidebar .aioseo-post-general .edit-snippet, .aioseo-post-settings-modal .md-tabs-navigation > button:first-child', function (e) {
				setTimeout( function () {
					var $inputPlace = $( 'body' ).find( '.aioseo-post-settings-modal #aioseo-post-settings-meta-description-row .add-tags .aioseo-view-all-tags' );
					insertGenerator( 'aio', $inputPlace );	
				}, 3000 );
			} );
		}
		
		// Rank Math Seo Plugin
		if ( window.rankMath ) {
			$( 'body' ).on('click', '.rank-math-editor > .components-tab-panel__tabs > button:first-child, .rank-math-edit-snippet', function (e) {
				setTimeout( function () {
					var $inputPlace = $( 'body' ).find( '.rank-math-editor-general [for="rank-math-editor-description"]' );
					insertGenerator( 'rank', $inputPlace );	
				}, 3000 );
			} );
		}
	} )
} );
