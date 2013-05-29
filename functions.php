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


/** 
 * Custom User Profile Fields
 *
 * Adds custom fields to the user profile page in the Wordpress admin.
 */ 
function my_custom_userfields( $contactmethods ) {
    $contactmethods['twitter']     = 'Twitter Handle';
    $contactmethods['google_plus']     = 'Google+ URL';
    
    return $contactmethods;
}
add_filter('user_contactmethods','my_custom_userfields',10,1);
 

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


/** 
 * Dynamic Sidebar
 *
 * This function provides the theme structure for sidebar widgets.
 */ 
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
}


/** 
 * Excerpt Functions
 *
 * These functions allow some HTML in your excerpt and give you the ability to utilize custom excerpt lengths. 
 */ 
function wp_new_excerpt($text) { // Fakes an excerpt if needed
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

?>
