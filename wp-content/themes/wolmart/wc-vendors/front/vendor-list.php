<?php
/**
 * Vendor List Template
 *
 * This template can be overridden by copying it to yourtheme/wc-vendors/front/vendors-list.php
 *
 * @author        Jamie Madden, WC Vendors
 * @package       WCVendors/Templates/Emails/HTML
 * @version       2.0.0
 *
 *    Template Variables available
 *  $shop_name : pv_shop_name
 *  $shop_description : pv_shop_description (completely sanitized)
 *  $shop_link : the vendor shop link
 *  $vendor_id  : current vendor id for customization
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<li class="vendor_list">
	<div class="vendor-wrap">
		<a href="<?php echo esc_url( $shop_link ); ?>">
			<figure class="vendor-avatar">
				<?php echo get_avatar( $vendor_id, 200 ); ?>
			</figure>
		</a>
		<a href="<?php echo esc_url( $shop_link ); ?>" class="btn btn-link vendor-name"><?php echo esc_html( $shop_name ); ?></a>
	</div>
</li>
