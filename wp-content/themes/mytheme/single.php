<?php get_header(); ?>
<?php	while ( have_posts() ) : the_post(); ?>
Title: <h1><?php the_title(); ?></h1>
Content: <p><?php the_content(); ?></p>
Author: <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author(); ?></a>
Date: <?php echo get_the_time( 'F j, Y', $post->ID ) ?>
Days Ago: <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?>
Time: <?php the_time(); ?>
Tag: <?php the_tags(); ?>
Expert: <?php the_excerpt(); ?>
Comment: <?php comments_popup_link('No Comments ', '1 Comment ', '% Comments '); ?>
Image: <?php echo the_post_thumbnail( array(300, 300, true) ); ?>
Image: <img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ));?>" /> 
Next Link: <?php next_posts_link(); ?>
Previous Link: <?php previous_posts_link(); ?>
<?php endwhile;	?>
<!------------------------------- Comment Section ---------------------------->
<?php 
if ( comments_open() || get_comments_number() ) {
comments_template();
}
?>
<!------------------------------- Search Bar ---------------------------->
<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <div>
  <label class="screen-reader-text" for="s">Search for:</label>
  <input type="text" value="" name="s" id="s" />
  <input type="submit" id="searchsubmit" value="Search" />
  </div>
</form>
<!---------------- --------------- Category ---------------------------->
<?php       
      $args = array(
      'orderby'    => 'ID', 
      'order'      => 'ASC',
      'hide_empty' => false
      );            
      $tax_terms = get_terms('category', $args);
      ?> 
<div class="category-link">
    <h4> <strong>Category</strong></h4>
     <ul class="list-group">     
          <?php foreach($tax_terms as $term_single) { ?>  
          <li  class="list-group-item"><a href="<?php echo home_url();?>/category/<?php echo $term_single->slug; ?>"><?php echo $term_single->name; ?> <span>(<?php echo $term_single->count; ?>)</span></a></li>         
          <?php } ?>
     </ul>
</div>

<!-------------- ------------- Tag ---------------------------->
<?php $tags = get_tags(); ?>
<div class="tags">
      <?php foreach ( $tags as $tag ) { ?>
      <a href="<?php echo get_tag_link( $tag->term_id ); ?> " rel="tag"><?php echo $tag->name; ?></a>
      <?php } ?>
</div>
<?php get_footer(); ?>
