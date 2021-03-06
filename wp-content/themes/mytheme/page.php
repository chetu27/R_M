<?php get_header(); ?>
<?php
	while (have_posts()) : the_post();
	//the_title();
	the_content();
	the_post_thumbnail();
	endwhile;
	wp_reset_postdata();
?>


<?php //get_sidebar( 'content-bottom' ); ?>
<?php //get_sidebar(); ?>
<?php get_footer(); ?>
