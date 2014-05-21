<?php get_header(); ?>
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    	<?php get_template_part('loop', 'index'); ?>
        
    <?php endwhile; ?>
    
        <div class="navigation">
            <div class="next-posts"><?php next_posts_link(); ?></div>
            <div class="prev-posts"><?php previous_posts_link(); ?></div>
        </div>
    
    <?php else : ?>
    
        <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
            <h1>Not Found</h1>
        </div>
    
    <?php endif; ?>

<?php get_footer(); ?>
