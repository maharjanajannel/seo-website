<?php
/**
 * seo vietnam functions and definitions
 *
 * @package seo vietnam
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'seo_vietnam_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function seo_vietnam_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on seo vietnam, use a find and replace
	 * to change 'seo-vietnam' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'seo-vietnam', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'seo-vietnam' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	/**
	 * Setup the WordPress core custom background feature.
	 */
	add_theme_support( 'custom-background', apply_filters( 'seo_vietnam_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add image sizes
	add_image_size( 'home-slide', 1000, 9999, false );
}
endif; // seo_vietnam_setup
add_action( 'after_setup_theme', 'seo_vietnam_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function seo_vietnam_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'seo-vietnam' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'seo_vietnam_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function seo_vietnam_scripts() {
	wp_enqueue_style( 'seo-vietnam-style', get_stylesheet_directory_uri().'/css/main.css');

	wp_enqueue_script( 'seo-vietnam-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'seo-vietnam-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	// wp_enqueue_script('box-slider', get_template_directory_uri().'/js/vendor/jquery.bxslider.min.js',array('jquery'),'1.0', true);

	wp_enqueue_script('seo-js', get_template_directory_uri().'/js/seo.js',array('jquery', 'box-slider'),'1.0', true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'seo-vietnam-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'seo_vietnam_scripts' );

function seo_cpt() {
	if ( ! class_exists( 'Super_Custom_Post_Type' ) )
			return;

	$slideshow = new Super_Custom_Post_Type( 'slideshow', 'Slide', 'Slides', array(
		'supports' => array('title', 'editor', 'thumbnail', 'page-attributes')
	));

	# Test Icon. Should be a square grid.
	$slideshow->set_icon( 'sort' );

	// # Taxonomy test, should be like tags
	// $tax_tags = new Super_Custom_Taxonomy( 'tax-tag' );
	//
	// # Taxonomy test, should be like categories
	// $tax_cats = new Super_Custom_Taxonomy( 'tax-cat', 'Tax Cat', 'Tax Cats', 'category' );
	//
	// # Connect both of the above taxonomies with the post type
	// connect_types_and_taxes( $demo_posts, array( $tax_tags, $tax_cats ) );

	# Add a meta box with every field type
	// $slideshow->add_meta_box( array(
	//     'id'      => 'slideshow',
	//     'context' => 'normal',
	//     'fields'  => array(
	//       'image' => array('type' => 'media')
	//     )
	// ) );

	$testimonial = new Super_Custom_Post_Type('testimonial');

	$testimonial->set_icon('thumbs-up');
	// $testimonial->add_meta_box(array(
	//   'id'        => 'additional information',
	//   'context'   => 'normal',
	//   'fields'    => array(
	//     'school'      => array('type' => 'text'),
	//     'class'       => array('type' => 'text')
	//   )
	// ));

	$people = new Super_Custom_Post_Type('people', 'Person', 'People', array(
		'supports' => array('title', 'author', 'thumbnail', 'revisions', 'page-attributes'),
		'taxonomies' => array('category')
	));

	$people->set_icon('user');
	// $people->add_meta_box(array(
	//   'id'        => 'additional information',
	//   'context'   => 'normal',
	//   'fields'    => array(
	//     'position'      => array('type' => 'text'),
	//     'other titles'  => array('type' => 'textarea'),
	//     'image'       => array('type' => 'media')
	//   )
	// ));

	$partner = new Super_Custom_Post_Type('partner','Partner', 'Partners', array(
		'supports' => array('title', 'author', 'thumbnail', 'revisions', 'page-attributes')
	));

	$partner->set_icon('group');
	// $partner->add_meta_box(array(
	//   'id'        => 'additional information',
	//   'context'   => 'normal',
	//   'fields'    => array(
	//     'image'       => array('type' => 'media'),
	//     'about'       => array('type' => 'textarea'),
	//     'link'        => array('type'=> 'url')
	//   )
	// ));

	$program = new Super_Custom_Post_Type('program','Program', 'Programs', array(
		'supports' => array('title','editor', 'thumbnail', 'revisions', 'page-attributes')
	));

	$program->set_icon('windows');
	// $program->add_meta_box(array(
	//   'id'        => 'additional information',
	//   'context'   => 'normal',
	//   'fields'    => array(
	//     'image'                => array('type' => 'media'),
	//     'internship placement' => array('type' => 'textarea'),
	//     'training'             => array('type'=> 'textarea'),
	//     'mentoring'            => array('type'=> 'textarea'),
	//     'community service'    => array('type'=> 'textarea')
	//   )
	// ));
	// $program -> add_meta_box(array(
	//   'id'        => 'key facts',
	//   'context'   => 'side',
	//   'fields'    => array(
	//     'alumni'            => array('type' => 'text'),
	//     'employer partners' => array('type' => 'text'),
	//     'guest speakers'    => array('type' => 'text'),
	//     'community service' => array('type' => 'textarea')
	//   )
	//   ));

	$project = new Super_Custom_Post_Type('project', 'Project', 'Projects', array(
		'supports' => array('title','editor', 'thumbnail', 'revisions', 'page-attributes'),
		'taxonomies' => array('category')
	));

	$project->set_icon('cogs');
	// $project->add_meta_box(array(
	//   'id'        => 'additional information',
	//   'context'   => 'normal',
	//   'fields'    => array(
	//     'image'                => array('type' => 'media'),
	//     'completion'           => array('type' => 'number'),
	//     'funded'               => array('type'=> 'number'),
	//     'donate'               => array('type'=> 'wysiwyg'),
	//     'contact'              => array('type'=> 'wysiwyg')
	//   )
	// ));

}
add_action( 'after_setup_theme', 'seo_cpt' );


/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

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

