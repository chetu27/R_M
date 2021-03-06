<?php get_header(); ?>
  Title: <?php the_archive_title(); ?>
  Title:  <?php echo str_replace("Category: ", "", get_the_archive_title()); ?> 
  Description: <?php echo category_description(); ?>(OR)<?php the_archive_description(); ?>
  <?php if ( have_posts() ) : ?>
      <?php	while ( have_posts() ) : the_post(); ?>
      <?php the_title(); ?>
      <?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ));?>
      <?php the_content(); ?>/<?php echo substr($post->post_content, 0, 150);  ?>
      <a href="<?php echo get_permalink( $post->ID ); ?>" class="btn btn-small">Register</a>
      <?php endwhile; ?>
  <?php else : ?>
  <h1>No Data Found</h1>
  <?php	endif;
  ?>
<?php get_footer(); ?>
