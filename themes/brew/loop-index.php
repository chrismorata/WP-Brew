<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
    <?php the_content(); ?>
</div>