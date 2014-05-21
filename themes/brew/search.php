<?php get_header(); ?>

	<h1>Search Results for <?php /* Search Count */ $allsearch = &new WP_Query("s=$s&showposts=-1"); $key = wp_specialchars($s, 1); $count = $allsearch->post_count; _e(''); _e('<span class="search-terms">'); echo $key; _e('</span>'); _e(' &mdash; '); echo $count . ' '; _e('articles'); wp_reset_query(); ?></h1>
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h1><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a></h1>
		<?php the_excerpt();?>
	<?php endwhile; ?>

	<?php else : ?>

		<p>No posts found. Try a different search?</p>
		<?php get_search_form(); ?>

	<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
