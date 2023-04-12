<?php
/**
 * Header contact template
 *
 * @package Wolmart WordPress Framework
 * @since 1.0
 */

defined( 'ABSPATH' ) || die;

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'live_chat'      => '',
			'live_chat_link' => '#',
			'tel_num'        => '',
			'tel_num_link'   => '#',
			'delimiter'      => '',
			'icon'           => '',

			// For elementor inline editing
			'self'           => '',
		),
		$atts
	)
);

$live_chat_link_url = ! empty( $live_chat_link['url'] ) ? $live_chat_link['url'] : 'mailto:#';
$tel_num_link_url   = ! empty( $tel_num_link['url'] ) ? $tel_num_link['url'] : 'tel:#';
?>
<div class="contact">
	<a href="<?php echo esc_url( $tel_num_link_url ); ?>" aria-label="<?php esc_attr_e( 'Contact', 'wolmart-core' ); ?>">
		<i class="<?php echo esc_attr( $icon ); ?>"></i>
	</a>
	<div class="contact-content">
		<?php
		if ( ! empty( $atts['link']['url'] ) && $self ) {
			$self->add_link_attributes( 'url', $atts['link'] );
			$title = sprintf( '<a %1$s>%2$s</a>', $self->get_render_attribute_string( 'url' ), $title );
		}
		printf( '<a href="%1$s" class="live-chat"%3$s>%2$s</a>', esc_url( $live_chat_link_url ), esc_html( $live_chat ), ( ! empty( $live_chat_link['is_external'] ) ? ' target="nofollow"' : '' ) . ( ! empty( $live_chat_link['nofollow'] ) ? ' rel="_blank"' : '' ) );
		echo ' <span class="contact-delimiter">' . esc_html( $delimiter ) . '</span> ';
		printf( '<a href="%1$s" class="telephone"%3$s>%2$s</a>', esc_url( $tel_num_link_url ), esc_html( $tel_num ), ( ! empty( $tel_num_link['is_external'] ) ? ' target="nofollow"' : '' ) . ( ! empty( $tel_num_link['nofollow'] ) ? ' rel="_blank"' : '' ) );
		?>
	</div>
</div>



