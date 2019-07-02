<?php
/*
Plugin Name: FIlter WIth Ajax 
Plugin URI: http://wordpress.org/
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
Author: Matt Mullenweg
Version: 1.7.2
Author URI: http://ma.tt/
*/


class ProductCategoryFilter{

    function __construct(){
        add_action( 'init', [$this,'hooking'] );
    }
    function hooking(){
        add_action( 'wp_enqueue_scripts', [$this,'my_scripts_method'] );
        add_filter( 'theme_page_templates', [$this,'fullWidthPage' ]);
        add_filter( 'template_include', [$this,'templeateLocation' ]);
        add_action( 'wp_ajax_product_filter', [$this,'my_ajax_callback_function'] );    // If called from admin panel
        add_action( 'wp_ajax_nopriv_product_filter', [$this,'my_ajax_callback_function'] );    // If called from front end
        add_shortcode( 'product_filter',  [$this,'filter_shortcode'] );
    }
    function fullWidthPage($page_templates){
        // Add custom template named template-custom.php to select dropdown
        $page_templates['productfullwidth-page.php'] = __('ProductCat Fullwidth');
        return $page_templates;
    }
    function templeateLocation( $template ) {
        if(  get_page_template_slug() === 'productfullwidth-page.php' ) {
        $template = plugin_dir_path( __FILE__ ).'template/productfullwidth-page.php';
        }
        return $template;
    }
    function my_scripts_method() { 
        wp_enqueue_style('filter-css', plugin_dir_url( __FILE__ ) . 'filter.css', array(),'1.0', 'all' );
        wp_enqueue_script('filter-js', plugin_dir_url( __FILE__ ) . 'filter.js', array( 'jquery' ),'1.0', true );
        wp_localize_script('filter-js','ajaxurlbook',admin_url("admin-ajax.php"));
    }

    function product_query_by_catid($cat_id){
        global $post;
         $query_args = array(
            'post_type'             => 'product', 
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'terms' => $cat_id,
                    'operator' => 'IN',
                )
            )
        );
        $posts_array = get_posts( $query_args );
        ob_start();
        $return_product = '';
        foreach ( $posts_array as $post ) : setup_postdata( $post );
            $return_product .= '<li>'.get_the_title().'</li>';
        endforeach;  wp_reset_postdata();
        return $return_product.ob_get_clean();
    
    }

    function my_ajax_callback_function() {
        // Implement ajax function here
        $action = isset($_POST['action'])?$_POST['action']:null; 
        $cat_id = isset($_POST['id'])?$_POST['id']:null; 
        // echo $product_id 
        if ($action == 'product_filter') {
            echo $product_list = $this->product_query_by_catid($cat_id) ;
        }
        die();
    }

    function filter_shortcode( $atts, $content =null ) {
        extract(shortcode_atts(array(
            
        ), $atts));

        $result = '';
        ob_start(); 
        ?>
        <div class="filter-button">
            <?php 
                $product_tarm = get_terms('product_cat');
                foreach ($product_tarm as  $term) {
                echo "<button class='button catagory_filter_button' data-id='{$term->term_id}' >{$term->name}</button>";
                }
            ?>
        </div>
        <div class="product-list">
                <?php 
                    $cat_id = $product_tarm[1]->term_id;
                    echo $this->product_query_by_catid($cat_id);
                ?>
        </div>

        <?php
        $result .= ob_get_clean();
        return $result;
    }

 
}

new ProductCategoryFilter();
















