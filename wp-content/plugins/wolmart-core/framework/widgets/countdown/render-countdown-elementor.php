<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Heading Countdown Render
 *
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'date'        => '',
			'type'        => 'block',
			'label'       => 'Offer Ends In:',
			'label_type'  => '',
			'label_pos'   => '',
			'date_format' => array( 'D', 'H', 'M', 'S' ),
			'timezone'    => '',
			'hide_split'  => false,
		),
		$atts
	)
);

$html = '';

if ( $date ) {
	$until = strtotime( $date );
	$now   = strtotime( 'now' );
	$until = $until - $now;

	$class = 'countdown';
	if ( $label_pos ) {
		$class .= ' outer-period';
	}
	if ( $timezone ) {
		$class .= ' user-tz';
	}
	if ( true == $hide_split ) {
		$class .= ' no-split';
	}

	$format = '';
	if ( is_array( $date_format ) ) {
		foreach ( $date_format as $f ) {
			$format .= $f;
		}
	} else {
		$format = str_replace( ',', '', $date_format );
	}

	$html .= '<div class="countdown-container ' . ( $type ) . '-type">';

	if ( 'inline' == $type ) {
		$html .= '<label class="countdown-label">' . sanitize_text_field( $label ) . '</label>';
	}

	$html .= '<div class="' . esc_attr( $class ) . '" data-until="' . esc_attr( $until ) . '" data-relative="true" ' . ( 'inline' == $type ? 'data-compact="true" ' : ' ' ) . ( 'short' == $label_type ? ' data-labels-short="true"' : '' ) . ' data-format="' . esc_attr( $format ) . '" data-time-now="' . esc_attr( str_replace( '-', '/', current_time( 'mysql' ) ) ) . '" >';

	if ( 'block' == $type ) {
		$html .= '<span class="countdown-row countdown-show' . ( is_array( $date_format ) ? count( $date_format ) : 0 ) . '">';

		$formats = 'short' == $label_type ? array(
			'Y' => esc_html__( 'Years', 'wolmart-core' ),
			'O' => esc_html__( 'Months', 'wolmart-core' ),
			'W' => esc_html__( 'Weeks', 'wolmart-core' ),
			'D' => esc_html__( 'Days', 'wolmart-core' ),
			'H' => esc_html__( 'Hrs', 'wolmart-core' ),
			'M' => esc_html__( 'Mins', 'wolmart-core' ),
			'S' => esc_html__( 'Secs', 'wolmart-core' ),
		) : array(
			'Y' => esc_html__( 'Years', 'wolmart-core' ),
			'O' => esc_html__( 'Months', 'wolmart-core' ),
			'W' => esc_html__( 'Weeks', 'wolmart-core' ),
			'D' => esc_html__( 'Days', 'wolmart-core' ),
			'H' => esc_html__( 'Hours', 'wolmart-core' ),
			'M' => esc_html__( 'Minutes', 'wolmart-core' ),
			'S' => esc_html__( 'Seconds', 'wolmart-core' ),
		);

		if ( is_array( $date_format ) ) {
			foreach ( $date_format as $item ) {
				$html .= '<span class="countdown-section"><span class="countdown-amount">00</span><span class="countdown-period">' . $formats[ $item ] . '</span></span>';
			}
		}

		$html .= '</span>';

	} else {
		$html .= '00 : 00 : 00';
	}

	$html .= '</div>';

	$html .= '</div>';
}

echo wolmart_escaped( $html );
