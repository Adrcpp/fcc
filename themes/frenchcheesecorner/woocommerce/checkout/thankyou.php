<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="woocommerce-order">
    <div class="bg-black thanks-page">
        <div class="contaner">
            <?php if ( $order ) : ?>

                <?php if ( $order->has_status( 'failed' ) ) : ?>

                    <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

                    <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                        <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
                        <?php if ( is_user_logged_in() ) : ?>
                            <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My account', 'woocommerce' ); ?></a>
                        <?php endif; ?>
                    </p>

                <?php else : ?>

                    <div class="text-center">
                        <h1 class="title-home title-white hero-title">thank you!</h1>
                        <h4 class="sub-title">Your order is one the way!</h4>
                    </div>

                <?php endif; ?>

            <?php else : ?>
                <div class="text-center">
                    <h1 class="title-home title-white hero-title">thank you!</h1>
                    <h4 class="sub-title">Your order is one the way!</h4>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<div class="mt-3 p-4">
    <?php  Widget_Social::render_widget(false); ?>
</div>
