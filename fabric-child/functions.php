<?php
/**
 * Child-Theme functions and definitions
 */

// Load rtl.css because it is not autoloaded from the child theme
if ( ! function_exists( 'fabric_child_load_rtl' ) ) {
	add_filter( 'wp_enqueue_scripts', 'fabric_child_load_rtl', 3000 );
	function fabric_child_load_rtl() {
		if ( is_rtl() ) {
			wp_enqueue_style( 'fabric-style-rtl', get_template_directory_uri() . '/rtl.css' );
		}
	}
}

add_filter('woocommerce_get_price_html', 'custom_price_display', 10, 2);
function custom_price_display($price, $product) {
    // Check if the product is variable
    if ($product->is_type('variable')) {
        // Get the variation prices
        $variations = $product->get_available_variations();
        $variation_prices = array();

        // Loop through variations
        foreach ($variations as $variation) {
            $variation_prices[] = $variation['display_price'];
        }

        // Get the min and max prices
        $min_price = min($variation_prices);
        $max_price = max($variation_prices);

        // If min and max prices are different, display the range
        if ($min_price !== $max_price) {
            // $price = wc_price($min_price/1.42);
           $price = wc_price($min_price/1.42) . ' - ' . wc_price($max_price/1.42);
           $price = $price.' /&#x33A1';
        } else {
            // If min and max prices are the same, display a single price
            $price = wc_price($min_price);
        }
    }

    return $price;
}

function add_bootstrap(){
    ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php
}
function add_bootstrapjs(){
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script type="text/javascript">
        jQuery( '.variations_form' ).each( function() {
        jQuery(this).on( 'found_variation', function( event, variation ) {
            var price = variation.display_price;//selectedprice
            jQuery('.price-per-box').html('$'+price)
            //(Math.round(price/1.42 * 100) / 100).toFixed(2)
            jQuery('.price-per-meter').html('$'+(Math.round(price/1.42 * 100) / 100).toFixed(2))

        });
    });
    </script>
    <?php
}
add_action('wp_head','add_bootstrap');
add_action('wp_footer','add_bootstrapjs');



?>