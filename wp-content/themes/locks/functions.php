<?php
require_once 'includes/content.php';
require_once 'includes/ajax.php';

/**
 * locks functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package locks
 */
if ( ! function_exists( 'locks_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function locks_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on locks, use a find and replace
	 * to change 'locks' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'locks', get_template_directory() . '/languages' );
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'locks' ),
	) );
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'locks_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'locks_setup' );
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function locks_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'locks_content_width', 640 );
}
add_action( 'after_setup_theme', 'locks_content_width', 0 );
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function locks_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'locks' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'locks' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Menus', 'locks' ),
		'id'            => 'footer-menus',
		'description'   => esc_html__( 'Add footer menus.', 'locks' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'locks_widgets_init' );
/**
 * Enqueue scripts and styles.
 */
function locks_scripts() {
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css' );
	wp_enqueue_style( 'owl-theme', get_template_directory_uri() . '/css/owl.theme.css' );
    wp_enqueue_style( 'locks-style', get_stylesheet_uri(), array('bootstrap-styles') );
	wp_enqueue_script( 'locks-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), '20151217', true );
	wp_enqueue_script( 'customimr', get_template_directory_uri() . '/js/custom-imr.js', array('jquery'), '20151216', true );
	
	wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js', array('jquery'), '20151216', true );
	wp_enqueue_script( 'locks-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
    if ( is_singular( 'safe' ) ) {
        wp_enqueue_style( 'magnific-popup-style', get_template_directory_uri() . '/css/magnific-popup.css' );
        wp_enqueue_style( 'responsive-tables-style', get_template_directory_uri() . '/css/responsive-tables.css' );
        wp_enqueue_script( 'magnific-popup-script', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
        wp_enqueue_script( 'responsive-tables-script', get_template_directory_uri() . '/js/responsive-tables.js', array( 'jquery' ), '', true );
    }
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'locks_scripts' );

//-----------------------------------------------------
// RI - Custom styles and scripts
//-----------------------------------------------------

/**
 * Register custom styles and scripts
 */
wp_register_style( 'ri-global-styles', get_stylesheet_directory_uri() . '/css/ri-global-styles.css' );
wp_register_style( 'ri-banner-styles', get_stylesheet_directory_uri() . '/css/ri-banner-styles.css' );
wp_register_script('bootstrap-scripts', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '', true);
wp_register_script('ri-global-scripts', get_stylesheet_directory_uri() . '/js/ri-global-scripts.js', array('jquery'), '', true);
wp_register_style( 'bootstrap-styles', get_stylesheet_directory_uri() . '/css/bootstrap.min.css' );
wp_register_style( 'font-awesome-pro', get_stylesheet_directory_uri() . '/fontawesome-pro/css/all.css' );
wp_register_style( 'product-page-styles', get_stylesheet_directory_uri() . '/css/product-page-styles.css' );
wp_register_style( 'modal', get_stylesheet_directory_uri() . '/css/modal.css' );

/**
 * Conditionally enqueue custom styles and scripts
 */
function ri_conditional_script_loading()
{
    if (!is_admin()) {
       wp_enqueue_style('ri-global-styles');
       wp_enqueue_style('ri-banner-styles');
       wp_enqueue_style('font-awesome-pro');
       wp_enqueue_style('modal');
       wp_enqueue_script('bootstrap-scripts');
       wp_enqueue_script('ri-global-scripts');
    }
   if (is_page(3048)) {
       wp_enqueue_style('bootstrap-styles');
       wp_enqueue_style('product-page-styles');
       wp_enqueue_script('bootstrap-scripts');
   }
}
add_action('wp_enqueue_scripts', 'ri_conditional_script_loading');

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' 	=> 'Global',
        'menu_title'	=> 'Global',
        'menu_slug' 	=> 'global-fields',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ));

}
//-----------------------------------------------------
// RI - Global Helper Functions
//-----------------------------------------------------
function get_clean_product_name($post_id) {
    if (get_post_type($post_id) == 'product') {
        return strtok(get_the_title($post_id), ' ');
    }
}

function get_icon_for_category_attribute($cat_name) {

    if (strtolower($cat_name) == 'security') {
        $attribute_icon = '<i class="far fa-lock-alt mr-2"></i>';
    } elseif (strtolower($cat_name) == 'fire protection') {
        $attribute_icon = '<i class="far fa-flame mr-2"></i>';
    } elseif (strtolower($cat_name) == 'functionality') {
        $attribute_icon = '<i class="far fa-door-closed mr-2"></i>';
    }

    return '<p><strong>' . $attribute_icon . ' '. $cat_name . '</strong></p>';
}
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';
/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
function register_safe_post_type() {
    if ( ! post_type_exists( 'safe' ) ) {
        register_post_type('safe', array(
            'public' => true,
            'label' => 'Safe Lines',
            'supports'     => array( 'title', 'editor', 'thumbnail' )
        ));
        register_taxonomy('safe_category', 'safe', array(
            'label'        => __( 'Safe Categories' ),
            'rewrite'      => array( 'slug' => 'safe-category' ),
            'hierarchical' => true
        ));
    }
}
add_action( 'init', 'register_safe_post_type' );
if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( 'Theme Settings' );
}
function single_post_hero_background() {
    $background_image = get_field( 'hero_background' );
    $style_str = '';
    if ( !empty( $background_image ) ) {
        $style_str = 'style="background-image: url(\'' . $background_image['url'] . '\');"';
    } else {
		$style_str = 'style="background-image: url(\'/wp-content/uploads/2016/08/KSnL_HeaderImg_Safes.jpg\');"';
        //$style_str = 'style="background-image: url(\'/wp-content/themes/locks/images/header/header-back.jpg\');"';
    }
    return $style_str;
}
function render_single_post_hero_headlines() {
	$headline = get_field( 'page_headline');
	$sub_headline = get_field( 'page_sub_headline');
    $html = '';
    $headline_array = [];
    
    // if ( !empty( $headline ) ) {
    //     $html .= '<h1 class="page-title">' . $headline . '</h1>';
    // } else {
    //     if (is_single()) {
    //         $html .= '<h1 class="page-title">' . get_the_title() . '</h1>';
    //     } else {
    //         $html .= '<h1 class="page-title">' . sanitize_post( get_queried_object() )->name . '</h1>';
    //     }
    // }
    // if ( !empty( $sub_headline) ) {
    //     $html .= '<h2>' . $sub_headline . '</h2>';
    // } else {
    //     if (is_single()) {
    //         $terms = get_the_terms( get_the_ID(), 'safe_category');
    //         $html .= '<h2>' . $terms[0]->name . '</h2>';
    //     }
    // }
    // echo $html;
    
    if ( !empty( $headline ) ) {
        $headline_array['headline'] = $headline;
    } else {
        if (is_single()) {
            $headline_array['headline'] = get_the_title();
        } else {
            $headline_array['headline'] = sanitize_post( get_queried_object() )->name;
        }
    }
    if ( !empty( $sub_headline) ) {
        $headline_array['subheadline'] = $sub_headline;
    } else {
        if (is_single()) {
            $terms = get_the_terms( get_the_ID(), 'safe_category');
            $headline_array['subheadline'] = $terms[0]->name;
        }
    }
    return $headline_array;
}
/**
 * Hide editor for Contact/Directions page.
 */
//add_action( 'admin_init', 'hide_editor' );
//function hide_editor() {
	// Get the Post ID.
//	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
//	if( !isset( $post_id ) ) return;
	// Get the name of the Page Template file.
//	$this_post = get_post( $post_id );
//	if($this_post->post_name == 'contact-directions'){
//		remove_post_type_support('page', 'editor');
//	}
//}
add_filter( 'pre_get_posts', 'tgm_io_cpt_search' );
/**
 * This function modifies the main WordPress query to include an array of
 * post types instead of the default 'post' post type.
 *
 * @param object $query  The original query.
 * @return object $query The amended query.
 */
function tgm_io_cpt_search( $query ) {
	if ( $query->is_search ) {
		$query->set( 'post_type', array( 'post', 'safe', 'page', 'attachment' ) );
	}
	
	return $query;
/*if ( $query->is_search ) 
   {
        $query->set('meta_query', array(
            array(
                'key' => 'models_%_model_code',
                'value' => $query->query_vars['s'],
                'compare' => 'LIKE'
            )
        ));
         $query->set('post_type', '__your_post_type__'); // optional
	}
	return $query;
*/
	
}
add_filter( 'posts_where', 'custom_posts_where', 10, 2 );
function custom_posts_where( $where, $query ) {
    
    global $wpdb;
    if ( is_main_query() && is_search() ) {
        $where .= " OR {$wpdb->posts}.post_title LIKE '%" . esc_sql( get_query_var( 's' ) ) . "%'";
                    
    }
    return $where;
    
}
function wpse_load_custom_search_template(){
    if( isset($_REQUEST['search']) == 'advanced' ) {
        require('advanced-search-result.php');
        die();
    }
}
add_action('init','wpse_load_custom_search_template');
add_filter( 'wpseo_breadcrumb_links', 'check_links' );
function check_links( $links ) {
	// $links[0]  => 'Home'
	// $links[1]  => '_SAFE_TAXONOMY_TERM_LINK_'
	// $links[2]  => '_SAFE_TAXONOMY_TERM_CPT1'
	// $links[3]  => '_SAFE_TAXONOMY_TERM_CPT2' ....etc
	// New link structure for Safe Taxonomy Term and Safe CPT only
	// $links[0]  => 'Home'
	// $links[1]  => 'Safes Page'
	// $links[2]  => '_SAFE_TAXONOMY_TERM_LINK_'
	// $links[3]  => '_SAFE_TAXONOMY_TERM_CPT1'
	// $links[4]  => '_SAFE_TAXONOMY_TERM_CPT2' ....etc
 	if ( is_tax( 'safe_category') || is_singular( 'safe' )) {
		$safes_page_link = array(
			'text'   	 => 'Safes',
			'url'    	 => site_url() . '/safes',
			'allow_html' => 'true'
		);
		$new_links = array();
		$new_links[] = $links[0];
		$new_links[] = $safes_page_link;
		for ($i = 1; $i < count($links); $i++) {
			$new_links[] = $links[$i];
		}
	} else {
		$new_links = $links;
	}
	return $new_links;
}
############ BB
function mycode_add_rewrite_query_vars($vars)
{
  //array_push($vars, 'vids');
  array_push($vars, 'view');
  array_push($vars, 'viewblogdetail');
  array_push($vars, 'blog_id_1');
  array_push($vars, 'pgg');
   array_push($vars, 'bname');
  return $vars;
}
add_filter('query_vars', 'mycode_add_rewrite_query_vars');
add_rewrite_rule('^blog/([^/]*)/?', 'index.php?blog=blog','top');
//add_rewrite_rule( 'blogdetail/([^/]*)/?','index.php?pagename=blogdetail&blog_id_1=$matches[1]', 'top' );
add_rewrite_rule( 'Blog/([^/]*)/?','index.php?blog=blogg&pgg=$matches[1]', 'top' );
add_rewrite_rule( 'blogdetail/([^/]*)/([^/]*)/?','index.php?blogdetail=blogdetail&bname=$matches[2]&blog_id_1=$matches[1]', 'top' );
//add_rewrite_rule('^blog/([^/]*)/([^/]*)/?', 'index.php?blog=blog&pgg=pg&pgg=$matches[1]','top');
function my_page_function() 
	{
		
		if(isset($_REQUEST['view']) && $_REQUEST['view']=='blog' && !isset($_REQUEST['page']))
		{
		    wp_redirect( home_url( "/blog/" ));
		   ///require('myblog.php');   exit;
		}
		elseif(isset($_REQUEST['view']) && $_REQUEST['view']=='blog' && isset($_REQUEST['page']))
		{
		    wp_redirect( home_url( "/blog/" ).$_REQUEST['page']."/");
		   ///require('myblog.php');   exit;
		}
		elseif(isset($_REQUEST['blogdetail']) && $_REQUEST['blogdetail']!='')
		{
		     //require('blog_detail.php'); 
			// wp_redirect( home_url( "/blogdetail/" ).sanitize_title_with_dashes($_REQUEST['bname'])."/".$_REQUEST['blogdetail']."/");
			 //exit;
		}
    }
add_action("template_redirect","my_page_function");

/**
 * Woo Commerce functions
 * https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);
function my_theme_wrapper_start() {
  echo '<div id="primary" class="content-area"><main id="main" class="site-main" role="main">';
  get_template_part( 'template-parts/content', 'header-hero-safe' );
  echo '<div class="container-fixed">';
}
function my_theme_wrapper_end() {
  echo '</div></main></div>';
}
add_filter( 'woocommerce_breadcrumb_defaults', 'jk_change_breadcrumb_delimiter' );
function jk_change_breadcrumb_delimiter( $defaults ) {
	// Change the breadcrumb delimeter from '/' to '>'
	$defaults['delimiter'] = ' &gt; ';
	return $defaults;
}
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

/**	
 * Change number of products in Woo Commerce cat. row
 * https://docs.woocommerce.com/document/change-number-of-products-per-row/
 *
 */
// add_filter('loop_shop_columns', 'loop_columns');
// if (!function_exists('loop_columns')) {
// 	function loop_columns() {
// 		return 3; // 4 products per row
// 	}
// }