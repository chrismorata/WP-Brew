<?php
/** 
 * Remove Junk From <head>
 *
 * This gets rid of unnecessary tags that get inserted into the <head>.
 */ 
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);


/** 
 * Add Theme Features
 *
 * Add support for various theme features like menus and post thumbnails.
 */ 
add_theme_support( 'menus' );
add_theme_support( 'post-thumbnails' );

/* Custom Image Sizes */
//add_image_size('', 300, 300, true);


/** 
 * Add Theme Menus
 *
 * Add support for various theme menus.
 */ 
add_theme_support( 'menus' );
if (function_exists('register_nav_menus')) {
   	register_nav_menus(
		array(
			'main-navigation' => 'Main Navigation'
		)
	);
}


/** 
 * Custom User Profile Fields
 *
 * Adds custom fields to the user profile page in the Wordpress admin.
 */ 
function my_custom_userfields( $contactmethods ) {
    $contactmethods['twitter']     = 'Twitter Handle';
    //$contactmethods['google_plus']     = 'Google+ URL';
    
    return $contactmethods;
}
add_filter('user_contactmethods','my_custom_userfields',10,1);
 

/** 
 * Custom Post Types
 *
 * This function registers various post types.
 */
/*
add_action( 'init', 'create_post_type' );
function create_post_types() {
	register_post_type( 'acme_product',
		array(
			'labels' => array(
				'name' => __( 'Products' ),
				'singular_name' => __( 'Product' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'products'),
		)
	);
} 

/** 
 * Custom Taxonomies
 *
 * This function registers various custom taxonomies.
 */
/*
add_action( 'init', 'create_custom_taxonomies', 0 );
function create_custom_taxonomies()  {

	$labels = array(
		'name'                       => 'Categories',
		'singular_name'              => 'Category',
		'menu_name'                  => 'Categories',
		'all_items'                  => 'All Categories',
		'parent_item'                => 'Parent Category',
		'parent_item_colon'          => 'Parent Category:',
		'new_item_name'              => 'New Category',
		'add_new_item'               => 'Add New Category',
		'edit_item'                  => 'Edit Category',
		'update_item'                => 'Update Category',
		'separate_items_with_commas' => 'Separate categories with commas',
		'search_items'               => 'Search categories',
		'add_or_remove_items'        => 'Add or remove categories',
		'choose_from_most_used'      => 'Choose from the most used categories',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'rewrite'                    => array( 'slug' => '' )
	);
	register_taxonomy( '[label]', '[post-type]', $args );
}
*/


/** 
 * Dynamic Sidebars
 *
 * This function provides the theme structure for sidebar widgets.
 */ 
if ( function_exists('register_sidebar') ) {

    register_sidebar(array(
    	'name'=> 'Standard Sidebar',
    	'id' => 'sidebar',
    	'before_widget' => '<li id="%1$s" class="widget %2$s">',
    	'after_widget' => '</li>',
    	'before_title' => '<h3 class="widget-title"><span>',
    	'after_title' => '</span></h3>',
    ));
}


/** 
 * Custom Comment Structure
 *
 * A callback function for custom comment structure. 
 * 
 * Sample usage: wp_list_comments('avatar_size=60&callback=my_custom_comments');
 */ 
function my_custom_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
    global $post;
    
	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	
		<?php if ( 'div' != $args['style'] ) : ?>
		    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
		
		<div class="comment-content">
    		<div class="comment-author vcard">
    		    <div class="comment-avatar">
            		<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
            		<br />
            		<?php if ( $comment->user_id === $post->post_author ) { ?>
            		    <span class="comment-label-author">Post Author</span>
            		<?php } elseif ( user_can( $comment->user_id, 'administrator' ) ) { ?>
            		    <span class="comment-label-admin">Site Admin</span>
            		<?php } ?>
        		</div>
        		
        		<div class="comment-actions">
        		    <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
        		    
        		    <?php edit_comment_link(__('Edit'),'  ','' ); ?>
        		</div>
        		    		
        		<?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>
        		
        		<span class="comment-meta commentmetadata">        		
    	    		<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
    	    			<?php printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?>
    	    		</a>
	    		</span>
    		</div>
    		
            <?php if ($comment->comment_approved == '0') : ?>
            		<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
            		<br />
            <?php endif; ?>
            
		    <?php comment_text() ?>

    		
	    </div>
	<?php if ( 'div' != $args['style'] ) : ?>
	    </div>
	<?php endif; ?>
		
<?php
}


/** 
 * Post Thumbnail Functions
 *
 * These functions are exclusive to post thumbnails and add the various sizes.
 */ 
set_post_thumbnail_size( 300, 300, false );
//add_image_size( 'category-thumb', 300, 9999, true );

add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}

function get_avatar_url($get_avatar){
    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
    return $matches[1];
}


/** 
 * Excerpt Functions
 *
 * These functions allow some HTML in your excerpt and give you the ability to utilize custom excerpt lengths. 
 */ 
/* function wp_new_excerpt($text) { // Fakes an excerpt if needed
    $raw_excerpt = $text;
    
	if ( '' == $text ) {
		$text = get_the_content('');

		$text = strip_shortcodes( $text );

		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		
		$text = strip_tags($text, '<p>, <a>, <em>, <strong>');
		
		$excerpt_length = apply_filters('excerpt_length', 55);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		
		//$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
		$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
	    if ( count($words) > $excerpt_length ) {
	        array_pop($words);
	        $text = implode(' ', $words);
	        $text = $text . $excerpt_more;
	    } else {
	        $text = implode(' ', $words);
	    }
	}
	
	return apply_filters('wp_new_excerpt', $text, $raw_excerpt);
}

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'wp_new_excerpt');
*/

function wpe_excerptlength_news($length) {
    return 15;
}

function wpe_excerptlength_teaser($length) {
    return 30;
}
function wpe_excerptlength_index($length) {
    return 70;
}
function wpe_excerptmore($more) {
    return '...';
}

function wpe_excerpt($length_callback='', $more_callback='') {
    global $post;
    if(function_exists($length_callback)){
        add_filter('excerpt_length', $length_callback);
    }
    if(function_exists($more_callback)){
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<div class="post-excerpt">' . $output . '</div>';
    echo $output;
}


/** 
 * Post Pagination
 *
 * Inserts pagination links for posts.
 */
function get_pagination(){
    global $wp_query;
    $total = $wp_query->max_num_pages;
    // only bother with the rest if we have more than 1 page!
    if ( $total > 1 )  {
         // get the current page
         if ( !$current_page = get_query_var('paged') )
              $current_page = 1;
              
         echo paginate_links(array(
              'base' => get_pagenum_link(1) . '%_%',
              'format' => 'page/%#%/',
              'current' => $current_page,
              'total' => $total,
              'mid_size' => 4,
              'type' => 'list'
         ));
    }
}


/** 
 * Shortcode: Tweets
 *
 * Inserts Twitter tweet widget.
 */
/*function my_shortocde($atts, $content = null){
    extract(shortcode_atts(array(
           'attribute' => 'value'
        ), $atts));
    
    return $attribute;
    
}
add_shortcode('my-shortcode', 'my_shortcode');
*/


/** 
 * Google Analytics
 *
 * This inserts the Google Analytics code to the <head>.
 */ 
function add_google_analytics() { ?>
	
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-XXXXXXX-X']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	
	</script>

<?php
}
add_action('wp_head', 'add_google_analytics');


/** 
 * jQuery from CDN
 *
 * This inserts jQuery from Google.
 */ 
if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {
	wp_deregister_script('jquery');
	wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js", false, null);
	wp_enqueue_script('jquery');
}


/**
 * Guest Author
 *
 * Adds the ability to overwrite the author with a guest author.
 */
/*
add_filter( 'the_author', 'guest_author_name' );
add_filter( 'get_the_author_display_name', 'guest_author_name' );

function guest_author_name( $name ) {
	global $post;

	$author = get_post_meta( $post->ID, 'guest-author', true );

	if ( $author )
	$name = $author;

	return $name;
}
*/
