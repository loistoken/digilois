<?php
/**
 * The main template
 *
 * @package Wolmart WordPress Framework
 * @since 1.0
 */

defined( 'ABSPATH' ) || die;

if ( wolmart_doing_ajax() && isset( $_GET['only_posts'] ) ) {

	// Page content for ajax filtering in blog pages.
	wolmart_print_title_bar();
	wolmart_get_template_part( 'posts/layout' );

} else {

	get_header();

	do_action( 'wolmart_before_content' );

	?>
	<div class="page-content">
		<?php wolmart_get_template_part( 'posts/layout' ); ?>
	</div>
	<?php

	do_action( 'wolmart_after_content' );

	get_footer();

}
