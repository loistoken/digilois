/**
 * Wolmart Comment Image Admin Library
 * 
 * @since 1.0.0
 */
( function ( wp, $ ) {
    'use strict';

    window.WolmartCoreAdmin = window.WolmartCoreAdmin || {};

	/**
	 * Private Properties for Product Comment Image
	 */
    var file_frame, $btn;

	/**
	 * Product Image Comment methods for Admin
	 */
    var CommentImageAdmin = {

		/**
		 * Initialize Image Comment for Admin
		 */
        init: function () {
            this.onAddImage = this.onAddImage.bind( this );
            this.onRemoveImage = this.onRemoveImage.bind( this );
            this.onSelectImage = this.onSelectImage.bind( this );

            $( document.body )
                .on( 'click', '#wolmart-comment-images-metabox .button-image-upload', this.onAddImage )
                .on( 'click', '#wolmart-comment-images-metabox .button-image-remove', this.onRemoveImage );
        },


		/**
		 * Event handler on image selected
		 */
        onSelectImage: function () {
            var attachments = file_frame.state().get( 'selection' ),
                $previewer = $( '.wolmart-comment-img-preview-area' ),
                $input = $btn.siblings( 'input' ),
                $input_val = $input.val();

            file_frame.close();

            attachments.map( function ( attachment ) {
                attachment = attachment.toJSON();

                if ( attachment.id ) {
                    var attachment_image = attachment.sizes &&
                        attachment.sizes.thumbnail
                        ? attachment.sizes.thumbnail.url
                        : attachment.url;
                    $input_val = $input_val ? $input_val +
                        ',' + attachment.id : attachment.id;

                    $previewer.append(
                        '<div class="comment-img-wrapper" data-attachment_id="' +
                        attachment.id + '"><img src="' +
                        attachment_image +
                        '"><a href="#" class="button-image-remove"><span class="dashicons dashicons-dismiss"></span></a></div>' );
                }
            } );

            $input.val( $input_val ).trigger( 'change' );
        },

		/**
		 * Event handler on image added
		 */
        onAddImage: function ( e ) {
            e.preventDefault();
            $btn = $( e.currentTarget );

            // If the media frame already exists
            file_frame || (
                // Create the media frame.
                file_frame = wp.media.frames.downloadable_file = wp.media( {
                    title: 'Choose an image',
                    button: {
                        text: 'Use image'
                    },
                    multiple: true
                } ),

                // When an image is selected, run a callback.
                file_frame.on( 'select', this.onSelectImage )
            );

            file_frame.open();
            this.requireSave();
        },

		/**
		 * Event handler on image removed
		 */
        onRemoveImage: function ( e ) {
            var $btn = $( e.currentTarget ),
                $input = $( '#wolmart-comment-images-metabox input' ),
                $preview = $( '.wolmart-comment-img-preview-area' );

            $btn.parent().remove();
            var $input_val = '';

            $preview.find( 'div.comment-img-wrapper' ).each( function () {
                var attachment_id = $( this ).data( 'attachment_id' );
                $input_val = $input_val ? $input_val +
                    ',' + attachment_id : attachment_id;
            } );

            $input.val( $input_val ).trigger( 'change' );
            e.preventDefault();
        },
    }


	/**
	 * Product Image Admin Swatch Initializer
	 */
    WolmartCoreAdmin.commentImage = CommentImageAdmin;

    $( document ).ready( function () {
        WolmartCoreAdmin.commentImage.init();
    } );
} )( wp, jQuery );
