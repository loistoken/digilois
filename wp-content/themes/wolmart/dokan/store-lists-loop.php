<div id="dokan-seller-listing-wrap" class="grid-view">
	<div class="seller-listing-content">
		<?php if ( $sellers['users'] ) : ?>
			<ul class="dokan-seller-wrap">
				<?php
				foreach ( $sellers['users'] as $seller ) {
					$vendor            = dokan()->vendor->get( $seller->ID );
					$store_banner_id   = $vendor->get_banner_id();
					$store_name        = $vendor->get_shop_name();
					$store_url         = $vendor->get_shop_url();
					$store_rating      = $vendor->get_rating();
					$is_store_featured = $vendor->is_featured();
					$store_phone       = $vendor->get_phone();
					$store_info        = dokan_get_store_info( $seller->ID );
					$store_address     = dokan_get_seller_short_address( $seller->ID );
					?>

					<li class="dokan-single-seller woocommerce coloum-<?php echo esc_attr( $per_row ); ?> <?php echo ( ! $store_banner_id ) ? 'no-banner-img' : ''; ?>">
						<div class="store-wrapper">
							<div class="store-header">
								<div class="store-banner">
									<a href="<?php echo esc_url( $store_url ); ?>">
									<?php
									if ( $store_banner_id ) {
										echo wp_get_attachment_image( $store_banner_id, $image_size );
									} else {
										echo apply_filters(
											'wolmart_lazyload_images',
											'<img src="' . DOKAN_PLUGIN_ASSEST . '/images/default-store-banner.png" width="768" height="462" alt="' . esc_attr( $store_name ) . '">'
										);
									}
									?>
									</a>
								</div>
								<div class="featured-favourite">
									<?php if ( $is_store_featured ) : ?>
										<div class="featured-label"><?php esc_html_e( 'Featured', 'dokan-lite' ); ?></div>
									<?php endif ?>

									<?php do_action( 'dokan_seller_listing_after_featured', $seller, $store_info ); ?>
								</div>
							</div>

							<div class="store-content <?php echo ! $store_banner_id ? esc_attr( 'default-store-banner' ) : ''; ?>">
								<div class="seller-avatar">
									<?php echo get_avatar( $seller->ID, 150 ); ?>
								</div>
								<div class="store-data-container">
									<div class="store-data">
										<h2><a href="<?php echo esc_attr( $store_url ); ?>"><?php echo esc_html( $store_name ); ?></a></h2>

										<div class="featured-favourite">
											<?php if ( $is_store_featured ) : ?>
												<div class="featured-label"><?php esc_html_e( 'Featured', 'dokan-lite' ); ?></div>
											<?php endif ?>

											<?php do_action( 'dokan_seller_listing_after_featured', $seller, $store_info ); ?>
										</div>

										<?php if ( ! empty( $store_rating['count'] ) ) : ?>
											<div class="dokan-seller-rating" title="<?php echo sprintf( esc_attr__( 'Rated %s out of 5', 'dokan-lite' ), esc_attr( $store_rating['rating'] ) ); //phpcs:ignore ?>">
												<?php // echo wp_kses_post( dokan_generate_ratings( $store_rating['rating'], 5 ) ); ?>
												<?php echo wc_get_rating_html( $store_rating['rating'] ); ?>
												<p class="rating">
													<?php printf( esc_html__( '%s out of 5', 'dokan-lite' ), esc_html( $store_rating['rating'] ) ); //phpcs:ignore ?>
												</p>
											</div>
										<?php endif ?>

										<?php if ( ! dokan_is_vendor_info_hidden( 'address' ) && $store_address ) : ?>
											<?php
												$allowed_tags = array(
													'span' => array(
														'class' => array(),
													),
													'br'   => array(),
												);
											?>
											<p class="store-address mb-0"><?php echo wp_kses( $store_address, $allowed_tags ); ?></p>
										<?php endif ?>

										<?php if ( ! dokan_is_vendor_info_hidden( 'phone' ) && $store_phone ) { ?>
											<p class="store-phone">
												<i class="w-icon-phone" aria-hidden="true"></i> <?php echo esc_html( $store_phone ); ?>
											</p>
										<?php } ?>

										<?php do_action( 'dokan_seller_listing_after_store_data', $seller, $store_info ); ?>
									</div>
									<div class="store-action mt-2">
										<a href="<?php echo esc_url( $store_url ); ?>" class="btn btn-link btn-dark btn-underline"><?php esc_html_e( 'Visit Store', 'dokan-lite' ); ?><i class="w-icon-long-arrow-<?php echo is_rtl() ? 'left' : 'right'; ?>"></i></a>
									</div>
								</div>
							</div>

							<div class="store-footer">
								<div class="seller-avatar">
									<?php echo get_avatar( $seller->ID, 150 ); ?>
								</div>
								<?php
									do_action( 'dokan_seller_listing_footer_content', $seller, $store_info );
								?>
								<a href="<?php echo esc_url( $store_url ); ?>" class="btn btn-link btn-dark btn-underline"><?php esc_html_e( 'Visit Store', 'dokan-lite' ); ?><i class="w-icon-long-arrow-<?php echo is_rtl() ? 'left' : 'right'; ?>"></i></a>
							</div>
						</div>
					</li>

				<?php } ?>
				<li class="dokan-clearfix"></li>
			</ul> <!-- .dokan-seller-wrap -->

			<?php
			$user_count   = $sellers['count'];
			$num_of_pages = ceil( $user_count / $limit );

			if ( $num_of_pages > 1 ) {
				echo '<div class="pagination-container clearfix">';

				$pagination_args = array(
					'current'   => $paged,
					'total'     => $num_of_pages,
					'base'      => $pagination_base,
					'type'      => 'array',
					'prev_text' => esc_html__( '&larr; Previous', 'dokan-lite' ),
					'next_text' => esc_html__( 'Next &rarr;', 'dokan-lite' ),
				);

				if ( ! empty( $search_query ) ) {
					$pagination_args['add_args'] = array(
						'dokan_seller_search' => $search_query,
					);
				}

				$page_links = paginate_links( $pagination_args );

				if ( $page_links ) {
					$pagination_links  = '<div class="pagination-wrap">';
					$pagination_links .= '<ul class="pagination"><li>';
					$pagination_links .= join( "</li>\n\t<li>", $page_links );
					$pagination_links .= "</li>\n</ul>\n";
					$pagination_links .= '</div>';

					echo wolmart_strip_script_tags( $pagination_links ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
				}

				echo '</div>';
			}
			?>

		<?php else : ?>
			<p class="dokan-error"><?php esc_html_e( 'No vendor found!', 'dokan-lite' ); ?></p>
		<?php endif; ?>
	</div>
</div>
