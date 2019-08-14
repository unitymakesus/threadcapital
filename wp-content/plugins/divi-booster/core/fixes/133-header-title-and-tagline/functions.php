<?php
if (!defined('ABSPATH')) { exit(); } // No direct access

add_action('wp_head.css', 'db133_user_css'); 
add_action('et_html_logo_container', 'db133_add_title_and_tagline_to_content');
add_action('wp_footer.js', 'db133_add_title_and_tagline_via_jquery_as_fallback');

/* === Old output buffering method. Disabled, pending deletion ===
add_action('wp', 'db133_try_to_add_title_and_tagline_via_output_buffering', 10, 0);
function db133_try_to_add_title_and_tagline_via_output_buffering(){
    if ( is_feed() || is_admin() ){ return; }
	try { 
		if (ini_get('output_buffering')) {
			ob_start('db133_add_title_and_tagline_to_content');
		}
	} catch (Exception $e) { }
}
*/
 
function db133_add_title_and_tagline_to_content($content){
	$content = preg_replace('#(<img([^>]*?)id="logo"([^>]*?)/>)#','\\1'.db133_title_and_tagline_html(), $content); 
    return $content;
}

function db133_add_title_and_tagline_via_jquery_as_fallback($plugin) { ?>
	jQuery(function($) {
		if (!$('#logo-text').length) {
			$('#logo').after(<?php echo json_encode(db133_title_and_tagline_html()); ?>);
		}
	});
<?php 
}

if (!function_exists('db133_title_and_tagline_html')) {
	function db133_title_and_tagline_html() {
		$title = esc_html(db133_site_title());
		$tagline = esc_html(db133_site_tagline());
		$title_and_tagline_html = <<<END
<div id="db_title_and_tagline">	
	<h1 id="logo-text">{$title}</h1> 
	<h5 id="logo-tagline">{$tagline}</h5>
</div>
END;
		return apply_filters('db133_title_and_tagline_html', $title_and_tagline_html);
	}
}

if (!function_exists('db133_site_tagline')) {
	function db133_site_tagline() {
		$title = get_bloginfo('description');
		return apply_filters('db133_site_tagline', $title);
	}
}

if (!function_exists('db133_site_title')) {
	function db133_site_title() {
		$title = get_bloginfo('name');
		return apply_filters('db133_site_title', $title);
	}
}

function db133_user_css($plugin) { ?>
#db_title_and_tagline {
	display: inline;
}
#logo { 
	padding-right: 10px; 
}
#logo-text, #logo-tagline { 
	margin:0; 
	padding:0; 
	display:inline;
	vertical-align: middle;
}
#logo-tagline { 
	opacity: 0.7; 
	margin-left: 16px; 
	vertical-align: sub; 
}
@media only screen and (max-width: 767px) { 
	#logo-tagline { 
		display: none; 
	}
}
.et_hide_primary_logo .logo_container { 
	height: 100% !important; 
	opacity: 1 !important; 
}
.et_hide_primary_logo .logo_container #logo { 
	display: none; 
}
<?php 
}
