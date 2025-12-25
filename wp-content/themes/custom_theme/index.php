<?php get_header(); ?>

<main>
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <a href=<?php the_permalink();?>> <?php  the_title(); ?> </a> 
            <br>
        <?php endwhile; ?>
    <?php else : ?>
        <p>Không có bài viết</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
