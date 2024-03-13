<?php
/*
Plugin Name: Featured Products
Plugin URI: https://wadereynes.com
Description: Adds featured products into shop.
Version: 1.0
Author: Wade Reynes
Author URI: https://wadereynes.com
Text domain: woocommerce


*/

// Error if someone opens this directly and security purposes

defined('ABSPATH') or die("Go away");

define('WOOSLIDER_PATH', plugin_dir_url(__FILE__) );


// Load scripts and styles
function wooslider_scripts() {
    wp_enqueue_style('wooslider', WOOSLIDER_PATH . 'css/slick.css');
    wp_enqueue_style('wooslider-custom', WOOSLIDER_PATH . 'css/style.css');


    wp_enqueue_script('woosliderjs', WOOSLIDER_PATH . 'js/slick.min.js');
}
add_action('wp_enqueue_scripts', 'wooslider_scripts');

// Shortcode for featured products
function wooslider_shortcode() {
    $args = array(
        'posts_per_page' => 10,
        'post_type' => 'product',
        'meta_key' => '_thumbnail_id',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_visibility',
                'field' => 'name',
                'terms' => 'featured',
                'operator' => 'IN',
            )
        ),
    );
    $slider_products = new WP_Query($args);
    $product_of_the_day = get_option( '_wooslider_plugin_title' );
    echo "<div class='slider-box'>";
    echo "<h2> $product_of_the_day </h2>";
    echo "<ul class='slider-products'>";
    while($slider_products->have_posts()): $slider_products->the_post(); ?>
        <li>
        <?php the_post_thumbnail('shop_catalog'); ?>
            <?php the_title('<h3>', '</h3>'); ?>
            <?php the_excerpt();
            
            ?>
            <a class="view-product" href="<?php the_permalink() ?>">View Product</a>
            
        </li>

    <?php endwhile;
    wp_reset_postdata();
    echo "</ul>";
    echo "</div>";
}
add_shortcode('wooslider', 'wooslider_shortcode');

// Execute bxSlider script
function wooslider_execute() { ?>

    <script>
        $ = jQuery.noConflict();
        $(document).ready(function(){

            $(".slider-products").slick({
                arrows: true,
                autoplay: true,
                dots: false,
                infinite: true,
                speed: 1000,
                slidesToShow: 1,
                slidesToScroll: 1,
            });
        });
    </script>
    
<?php
}
add_action('wp_footer', 'wooslider_execute');


if(!class_exists('ContactPlugin')) {
    class WooSliderPlugin {

        public function __construct() {
            define('PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
            require_once( PLUGIN_PATH . 'vendor/autoload.php');
        }

        public function initialize() {
            include_once PLUGIN_PATH . 'includes/utilities.php';

            include_once PLUGIN_PATH . 'includes/options-page.php';
        }

    }
    $wooSliderPlugin = new WooSliderPlugin;
    $wooSliderPlugin->initialize();
}

