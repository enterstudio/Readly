<?php
/**
 * Readly functions and definitions
 *
 * @package Readly
 * @since Readly 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Readly 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 920; /* pixels */

/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );

if ( ! function_exists( 'readly_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Readly 1.0
 */
function readly_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Readly, use a find and replace
	 * to change 'readly' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'readly', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'readly' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 
		'aside', 'audio', 'chat', 'gallery', 'image', 'quote', 'status', 'link', 'video'
	) );
}
endif; // readly_setup
add_action( 'after_setup_theme', 'readly_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Readly 1.0
 */
function readly_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'readly' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'readly_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function readly_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

	wp_enqueue_script( 'wp-mediaelement' );
	
	wp_enqueue_style( 'wp-mediaelement' );

	wp_enqueue_script( 'jquery' );

	wp_enqueue_script( 'jquery-ui', get_template_directory_uri() . '/js/jquery-ui-1.10.2.custom.min.js', array(), '20130317' );

	wp_enqueue_script( 'readly', get_template_directory_uri() . '/js/readly.js', array(), '20130408' );

	if ( ! is_singular() && 'infinite-scroll' == get_theme_mod( 'page_navigation' ) )
		wp_enqueue_script( 'infinite-scroll', get_template_directory_uri() . '/js/jquery.infinitescroll.min.js', array( 'jquery' ), '2.0b.110415', true );
}
add_action( 'wp_enqueue_scripts', 'readly_scripts' );

// This theme uses its own gallery styles.
add_filter( 'use_default_gallery_style', '__return_false' );

// [big] shortcode
function readlyShortcodeBig( $atts, $content = null ) {
	return '<div class="readly_big">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'big', 'readlyShortcodeBig' );

// updated form for password protected posts
function readlyPasswordForm($content) {
	$before = array('>Password: <input name="post_password" id="');
	$after = array('><input name="post_password" placeholder="Password" class="password_protected" id=');
	$content = str_replace($before, $after, $content);
	return $content;
}
add_filter('the_password_form', 'readlyPasswordForm');

// infinite scroll
function readly_infinite_scroll_js() {
	if ( is_singular() || 'infinite-scroll' != get_theme_mod( 'page_navigation' ) ) return;
	?>
	<script type="text/javascript">
		jQuery(function() {
			var infinite_scroll = {
				loading: {
					img: "<?php echo get_stylesheet_directory_uri(); ?>/icons/loadmore.svg",
					msgText: "",
					finishedMsg: "<?php _e( 'The End', 'readly' ); ?>"
				},
				'nextSelector': '#nav-below .previous a',
				'navSelector': '#nav-below',
				'itemSelector': 'article',
				'contentSelector': '#content'
			};
			jQuery(infinite_scroll.contentSelector).infinitescroll(infinite_scroll, function(arrayOfNewElems) {
				fixLinks();
				fixVideos();
				jQuery(arrayOfNewElems).find('audio,video').mediaelementplayer();
			});
		});
	</script>
<?php
}
add_action( 'wp_footer', 'readly_infinite_scroll_js', 100 );