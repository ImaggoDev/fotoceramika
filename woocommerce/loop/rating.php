<?php

/**
 * Loop Rating
 *
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ( function_exists( 'wc_review_ratings_enabled' ) && ! wc_review_ratings_enabled() ) || ( ! function_exists( 'wc_review_ratings_enabled' ) && 'no' === get_option( 'woocommerce_enable_review_rating' ) ) ) {
	return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();

?>

<div class="woocommerce-product-rating">
	<div class="star-rating" title="<?php echo esc_attr( $average ); ?>">
		<span style="width:<?php echo ( 100 * ( $average / 5 ) ); ?>%">
			<?php /* translators: %s: Rating value */ ?>
			<strong class="rating"><?php echo esc_html( $average ); ?></strong> <?php printf( esc_html__( 'out of %1$s5%2$s', 'porto' ), '', '' ); ?>
		</span>
	</div>
	<?php if ( comments_open() ) : ?>
		<?php //phpcs:disable ?>
		<?php if ( $rating_count > 0 ) : ?>
			<?php /* translators: %s: Review count */ ?>
			<div class="review-link"><span class="woocommerce-review" rel="nofollow"><?php printf( _n( '%s opinia', '%s opinie', (int) $review_count, 'woocommerce' ), '<span class="count">' . ( (int) $review_count ) . '</span>' ); ?></span></div>
		<?php endif; ?>
		<?php //phpcs:enable ?>
	<?php endif; ?>
</div>
