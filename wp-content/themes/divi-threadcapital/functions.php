<?php
/**
* Make theme available for translation
*/
load_theme_textdomain( 'divi-thread', get_template_directory() . '/languages' );

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
	$theme_version = et_get_theme_version();
	wp_enqueue_style('divi/style', get_template_directory_uri() . '/style.css', false, $theme_version);
	wp_enqueue_style('ncruralcenter/style', get_stylesheet_directory_uri() . '/css/style.css', false, null);
	wp_enqueue_style('ncruralcenter/extras', get_stylesheet_directory_uri() . '/style.css', false, null);
  wp_enqueue_script('ncruralcenter/scripts', get_stylesheet_directory_uri() . '/scripts/main.js', false, null, true);
}, 100);

/**
 * Set image quality
 */
add_filter('jpeg_quality', function($arg){return 100;});

/**
 * Breadcrumbs setup for Justin Tadlock's Breadcrumbs Plugin
 */

// Add Shortcode for Breadcrumbs
add_shortcode('breadcrumbs', function($atts) {
	if ( function_exists( 'breadcrumb_trail' ) ) {
		ob_start();
		breadcrumb_trail();
		return ob_get_clean();
	}
});

// Remove Breadcrumbs inline styles
add_filter( 'breadcrumb_trail_inline_style', '__return_false' );

/**
 * Accessible mobile nav menu
 */
add_action('after_setup_theme', function() {
	remove_action( 'et_header_top', 'et_add_mobile_navigation' );
	add_action('et_header_top', 'a11y_mobile_navigation');
	function a11y_mobile_navigation(){
		if ( is_customize_preview() || ( 'slide' !== et_get_option( 'header_style', 'left' ) && 'fullscreen' !== et_get_option( 'header_style', 'left' ) ) ) {
			printf(
				'<div id="et_mobile_nav_menu">
					<div class="mobile_nav closed">
						<span class="select_page">%1$s</span>
						<a class="mobile_menu_toggle" href="#"></a>
					</div>
				</div>',
				esc_html__( 'Select Page', 'divi-thread' )
			);
		}
	}
});


/**
 * Team list shortcode
 */
add_shortcode('team-listing', function($atts) {
	$staff = new WP_Query([
		'post_type' => 'team',
		'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC',
	]);

	ob_start();

	if ($staff->have_posts()) : while ($staff->have_posts()) : $staff->the_post();
		?>
		<div class="row person" itemscope itemprop="author" itemtype="http://schema.org/Person">
			<div class="col_5_8">
				<h3 itemprop="name"><?php the_title(); ?></h3>
				<div class="title" itemprop="jobTitle"><?php the_field('title'); ?></div>
				<div><a itemprop="email" target="_blank" rel="noopener" href="mailto:<?php echo eae_encode_str(get_field('email')); ?>"><?php the_field('email'); ?></a></div>
				<?php the_advanced_excerpt(); ?>
			</div>
			<div class="col_3_8">
				<?php the_post_thumbnail('medium', ['alt' => __('Photograph of', 'divi-thread') . ' ' . get_the_title(), 'itemprop' => 'image']); ?>
				<div class="tagline">
					<?php the_field('tagline'); ?>
				</div>
			</div>
		</div>
		<?php
	endwhile; endif; wp_reset_postdata();

	return ob_get_clean();
});


/**
 * Process Graphic Shortcode
 */
add_shortcode('process-graphic', function($atts) {
	ob_start(); ?>
		<div class="process-graphic">
			<article>
				<img src="<?php bloginfo('stylesheet_directory'); ?>/images/graphic/apply.png" / alt="Image of clock">
				<p><?php _e('Apply in Minutes', 'divi-thread'); ?></p>
			</article>

			<span class="dash"></span>

			<article>
				<img src="<?php bloginfo('stylesheet_directory'); ?>/images/graphic/connect.png" alt="Image of connected people"/>
				<p><?php _e('Connect with Thread Capital Team', 'divi-thread'); ?></p>
			</article>

			<span class="dash"></span>

			<article>
				<img src="<?php bloginfo('stylesheet_directory'); ?>/images/graphic/submit.png" alt="Image of submit document"/>
				<p><?php _e('Submit Verification Documents', 'divi-thread'); ?></p>
			</article>

			<div class="dash"></div>

			<article>
				<img src="<?php bloginfo('stylesheet_directory'); ?>/images/graphic/funding.png" alt="Image of money"/>
				<p><?php _e('Receive Funding', 'divi-thread'); ?></p>
			</article>
		</div>

	<?php return ob_get_clean();
});

/**
 * Filter the excerpt "read more" string.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
add_filter( 'excerpt_more', function ( $more ) {
	$link_open = '... <a href="' . get_the_permalink() . '">';
  $read_more = __('Read More', 'divi-thread');
	$link_close = '</a>';

	return $link_open . $read_more . $link_close;
} );

/**
 * Add top-header widget area
 */
add_filter('widgets_init', function() {
	$config = [
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ];
  register_sidebar([
    'name'          => __('Top Header Left', 'divi-thread'),
    'id'            => 'top-header-left'
  ] + $config);
  register_sidebar([
    'name'          => __('Top Header Right', 'divi-thread'),
    'id'            => 'top-header-right'
  ] + $config);
});



/**
*	This will hide the Divi "Project" post type.
*	Thanks to georgiee (https://gist.github.com/EngageWP/062edef103469b1177bc#gistcomment-1801080) for his improved solution.
*/
add_filter( 'et_project_posttype_args', function( $args ) {
 	return array_merge( $args, array(
 		'public'              => false,
 		'exclude_from_search' => false,
 		'publicly_queryable'  => false,
 		'show_in_nav_menus'   => false,
 		'show_ui'             => false
 	));
}, 10, 1);


/**
 * Change WordPress email sender name and email
 */
add_filter( 'wp_mail_from_name', function( $original_email_from ) {
  return 'Thread Capital';
});

add_filter('wp_mail_from', function($original_email_from) {
  return 'wordpress@threadcap.org';
});
