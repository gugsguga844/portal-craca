<?php
/**
 * Portal Garganta functions and definitions
 *
 * @package Portal_Craca
 */

if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Category color map — returns the Tailwind class suffix for each category slug.
 */
function portal_get_category_colors() {
	return array(
		'documentarios'  => array(
			'slug'  => 'documentarios',
			'color' => '#ff6625',
			'class' => 'documentarios',
		),
		'cidade'         => array(
			'slug'  => 'cidade',
			'color' => '#ff76ce',
			'class' => 'cidade',
		),
		'entretenimento' => array(
			'slug'  => 'entretenimento',
			'color' => '#f3fad5',
			'class' => 'entretenimento',
		),
		'esportes'       => array(
			'slug'  => 'esportes',
			'color' => '#00b4d8',
			'class' => 'esportes',
		),
		'denuncia'       => array(
			'slug'  => 'denuncia',
			'color' => '#ef233c',
			'class' => 'denuncia',
		),
		'coisas'         => array(
			'slug'  => 'coisas',
			'color' => '#b185db',
			'class' => 'coisas',
		),
		'politica'       => array(
			'slug'  => 'politica',
			'color' => '#80ed99',
			'class' => 'politica',
		),
	);
}

/**
 * Get the category color class suffix for a post.
 * Returns the slug-based class suffix (e.g. 'documentarios') or 'documentarios' as default.
 */
function portal_get_post_cat_class( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	$categories = get_the_category( $post_id );
	$color_map  = portal_get_category_colors();

	if ( ! empty( $categories ) ) {
		foreach ( $categories as $cat ) {
			if ( isset( $color_map[ $cat->slug ] ) ) {
				return $color_map[ $cat->slug ]['class'];
			}
		}
	}
	return 'documentarios'; // fallback
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function portal_craca_setup() {
	load_theme_textdomain( 'portal-craca', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	// Register navigation menus
	register_nav_menus(
		array(
			'menu-1'       => esc_html__( 'Primary', 'portal-craca' ),
			'categories'   => esc_html__( 'Categories Navigation', 'portal-craca' ),
			'footer-menu'  => esc_html__( 'Footer Menu', 'portal-craca' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support(
		'custom-background',
		apply_filters(
			'portal_craca_custom_background_args',
			array(
				'default-color' => '0e110e',
				'default-image' => '',
			)
		)
	);

	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Add custom image sizes
	add_image_size( 'hero-large', 1400, 700, true );
	add_image_size( 'card-medium', 600, 400, true );
}
add_action( 'after_setup_theme', 'portal_craca_setup' );

/**
 * Set the content width in pixels.
 */
function portal_craca_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'portal_craca_content_width', 1280 );
}
add_action( 'after_setup_theme', 'portal_craca_content_width', 0 );

/**
 * Register widget area.
 */
function portal_craca_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'portal-craca' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'portal-craca' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'portal_craca_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function portal_craca_scripts() {
	wp_enqueue_style( 'portal-craca-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'portal-craca-style', 'rtl', 'replace' );

	// Google Fonts — Inter for body text
	wp_enqueue_style(
		'google-fonts-inter',
		'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap',
		array(),
		null
	);

	wp_enqueue_script( 'portal-craca-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'portal_craca_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
