<?php
// Start the engine
include_once( get_template_directory() . '/lib/init.php' );

// Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', ) );

// Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

// Add thumbnail sizes
// add_image_size( 'testimonial', 70, 70, true );

//* Add support for footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

// Remove sidebars
unregister_sidebar( 'sidebar-alt' );

// Remove site layouts
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

// Remove all wraps
add_theme_support( 'genesis-structural-wraps', array() );

// Replace default style sheet
function premiumwp_2016_replace_default_style_sheet() {
	return CHILD_URL . '/main.css';
}
add_filter( 'stylesheet_uri', 'premiumwp_2016_replace_default_style_sheet', 10, 2 );

//* Enqueue scripts and styles
function premiumwp_2016_enqueue_scripts() {
	wp_enqueue_script( 'productivemuslimacademy-footer-scripts', get_stylesheet_directory_uri() . '/js/footer-scripts-min.js', array('jquery'), '', true );
	// wp_enqueue_script( 'getresponse-10588803', 'http://app.getresponse.com/view_webform.js?wid=10588803&mg_param1=1&u=SKsu', array(), '', true );
}
add_action( 'wp_enqueue_scripts', 'premiumwp_2016_enqueue_scripts' );

//* Custom CSS
function premiumwp_2016_custom_css() {
	if ( has_post_thumbnail( $post->ID ) ) {
		$image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		$image_url = $image_array[0];
	}
	else {
		$image_url = 'http://premiumwp.dev/wp-content/uploads/inner-header.jpg';
	}
?>
<style>
.entry-header {background-image: url('<?php echo $image_url; ?>');}
</style>
<?php
}
add_action( 'wp_head', 'premiumwp_2016_custom_css', 999 );

function premiumwp_2016_register_menus() {
	register_nav_menus(
		array(
			'menu-footer' => 'Footer Menü',
			'menu-offcanvas' => 'Mobil Menü'
		)
	);
}
add_action( 'init', 'premiumwp_2016_register_menus' );

// Remove default menu positions
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

// Remove the header
remove_action( 'genesis_header', 'genesis_do_header' );

function premiumwp_2016_custom_header() {
	// if ( !is_front_page() ) {
?>
<nav class="primary-nav uk-navbar uk-navbar-attached" data-uk--sticky="{media: 1024}">
	<div class="uk-container uk-container-center">
		<a class="uk-navbar-brand uk-visible-large" href="/"><img class="uk-margin uk-margin-remove" src="http://getuikit.com/docs/images/logo_uikit.svg" width="90" height="30" alt="UIkit"></a>
		<div class="uk-navbar-content uk-navbar-flip uk-visible-large">
			<a href="/honlapszolgaltatas-megrendelese/" class="uk-button uk-button-danger uk-button-large">Megrendelés</a>
		</div>
   		<?php wp_nav_menu( array(
   			'theme_location'	=> 'primary',
   			'container'			=> false,
   			'items_wrap'		=> '<ul id="%1$s" class="%2$s uk-navbar-nav uk-visible-large" data-uk-nav>%3$s</ul>',
   			'walker'			=> new premiumwp_2016_walker_primary_menu
   		) ); ?>
		<a href="#mobile-menu" class="uk-navbar-toggle uk-hidden-large uk-navbar-flip" data-uk-offcanvas></a>
		<a class="uk-navbar-brand uk-navbar-center uk-hidden-large" href="/">
			<img src="http://getuikit.com/docs/images/logo_uikit.svg" width="90" height="30" alt="UIkit">
		</a>
	</div>
</nav>
<?php
	// }
}
add_action( 'genesis_header', 'premiumwp_2016_custom_header' );

function premiumwp_2016_custom_entry_header_before() {
	echo '<img class="uk-invisible" src="" width="" height="" alt="">';
	echo '<div class="uk-position-cover uk-flex uk-flex-center uk-flex-middle">';
}
add_action( 'genesis_entry_header', 'premiumwp_2016_custom_entry_header_before', 5 );

function premiumwp_2016_custom_entry_header_after() {
	echo '</div>';
}
add_action( 'genesis_entry_header', 'premiumwp_2016_custom_entry_header_after', 10 );

function premiumwp_2016_before_entry_content() {
	echo '<div class="uk-container uk-container-center uk-margin-large-top uk-margin-large-bottom">';
	echo '<div class="uk-grid uk-grid-preserve">';
	echo '<div class="uk-width-large-3-4 uk-container-center">';
}
add_action( 'genesis_before_entry_content', 'premiumwp_2016_before_entry_content' );

function premiumwp_2016_after_entry_content() {
	echo '</div></div></div>';
}
add_action( 'genesis_after_entry_content', 'premiumwp_2016_after_entry_content' );

function premiumwp_2016_site_inner_attributes( $attributes ) {
	$attributes['class'] .= ' uk-container uk-container-center uk-margin-large-top uk-margin-large-bottom';
	return $attributes;
}
// add_filter( 'genesis_attr_site-inner', 'premiumwp_2016_site_inner_attributes' );

function premiumwp_2016_content_sidebar_wrap_attributes( $attributes ) {
	$attributes['class'] .= ' uk-grid uk-grid-preserve';
	return $attributes;
}
// add_filter( 'genesis_attr_content-sidebar-wrap', 'premiumwp_2016_content_sidebar_wrap_attributes' );

function premiumwp_2016_content_attributes( $attributes ) {
	$attributes['class'] .= ' uk-width-large-2-3 uk-container-center';
	return $attributes;
}
// add_filter( 'genesis_attr_content', 'premiumwp_2016_content_attributes' );

function premiumwp_2016_entry_header_attributes( $attributes ) {
	$attributes['class'] .= ' uk-cover-background uk-block uk-block-large uk-text-center uk-contrast';
	if ( is_front_page() ) {
		$attributes['class'] .= ' uk-height--viewport';
	}
	return $attributes;
}
add_filter( 'genesis_attr_entry-header', 'premiumwp_2016_entry_header_attributes' );

function premiumwp_2016_entry_title_attributes( $attributes ) {
	$attributes['class'] .= ' uk-article-title uk-margin-remove';
	return $attributes;
}
add_filter( 'genesis_attr_entry-title', 'premiumwp_2016_entry_title_attributes' );

function premiumwp_2016_footer_widget_areas_attributes( $attributes ) {
	$attributes['class'] .= ' uk-grid uk-grid-width-large-1-3';
	return $attributes;
}
add_filter( 'genesis_attr_footer-widgets', 'premiumwp_2016_footer_widget_areas_attributes' );

function premiumwp_2016_footer_widget_areas_grid( $output ) {
	return '<div id="footer-widgets-area" class="uk-block uk-block-muted"><div class="uk-container uk-container-center">' . $output . '</div></div>';
}
add_filter( 'genesis_footer_widget_areas', 'premiumwp_2016_footer_widget_areas_grid' );

function premiumwp_2016_site_footer_attributes( $attributes ) {
	$attributes['class'] .= ' uk-block uk-block-secondary uk-block-large uk-contrast uk-text-center';
	return $attributes;
}
add_filter( 'genesis_attr_site-footer', 'premiumwp_2016_site_footer_attributes' );

// Customize the entire footer
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'premiumwp_2016_custom_footer' );
function premiumwp_2016_custom_footer() {
	?>
<div class="uk-container uk-container-center uk-text-center">

                <ul class="uk-subnav uk-subnav-line uk-flex-center">
                    <li><a href="http://github.com/uikit/uikit">GitHub</a></li>
                    <li><a href="http://github.com/uikit/uikit/issues">Issues</a></li>
                    <li><a href="http://github.com/uikit/uikit/blob/master/CHANGELOG.md">Changelog</a></li>
                    <li><a href="https://twitter.com/getuikit">Twitter</a></li>
                </ul>

                <div class="uk-panel">
                    <p>Made by <a href="http://www.yootheme.com">YOOtheme</a> with love and caffeine.<br>Licensed under <a href="http://opensource.org/licenses/MIT">MIT license</a>.</p>
                    <a href="../index.html"><img src="http://getuikit.com/docs/images/logo_uikit.svg" width="90" height="30" title="UIkit" alt="UIkit"></a>
                </div>

            </div>
			<?php
}

function premiumwp_2016_offcanvas() {
?>
	<div id="offcanvas" class="uk-offcanvas">
   		<div class="uk-offcanvas-bar uk-offcanvas-bar-flip">
			<?php genesis_widget_area( 'mobile' ); ?>
   			<?php wp_nav_menu( array(
   				'theme_location'	=> 'menu-offcanvas',
   				'container'			=> false,
   				'items_wrap'		=> '<ul id="%1$s" class="%2$s uk-nav uk-nav-parent-icon uk-nav-offcanvas" data-uk-nav>%3$s</ul>',
   				'walker'			=> new premiumwp_2016_walker_offcanvas_menu
   			) ); ?>
   		</div>
	</div>
<?php
}
add_action( 'wp_footer', 'premiumwp_2016_offcanvas' );

class premiumwp_2016_walker_primary_menu extends Walker_Nav_Menu {
	// add classes to ul sub-menus
	function start_lvl( &$output, $depth=0, $args=array() ) {
		$classes = array( 'uk-nav-sub' );
		$class_names = implode( ' ', $classes );
		$output .= '<ul class="' . $class_names . '">';
	}
}

class premiumwp_2016_walker_offcanvas_menu extends Walker_Nav_Menu {
	// add classes to ul sub-menus
	function start_lvl( &$output, $depth=0, $args=array() ) {
		$classes = array( 'uk-nav-sub' );
		$class_names = implode( ' ', $classes );
		$output .= '<ul class="' . $class_names . '">';
	}
}

function premiumwp_2016_add_menu_parent_class( $items ) {
	$parents = array();

	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}

	foreach ( $items as $item ) {
		if ( in_array( $item->ID, $parents ) ) {
			$item->classes[] = 'uk-parent';
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'premiumwp_2016_add_menu_parent_class' );

function premiumwp_2016_special_nav_class( $classes, $item ) {
	if( in_array( 'current-menu-item', $classes ) ){
		$classes[] = 'uk-active ';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class' , 'premiumwp_2016_special_nav_class' , 10 , 2 );

//* Register widget areas
genesis_register_sidebar( array(
	'id'			=> 'mobile',
	'name'			=> 'Mobil'
) );
