<?php
/* Template Name: Blog */
get_header(); ?>
<?php $args = array('post_type' => 'post','posts_per_page'=>-3,'post_status' => 'publish','paged' => get_query_var('paged') ? get_query_var('paged') : 1);
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();?>	
image: <?php echo the_post_thumbnail( array(70, 70, true) ); ?> 
image: <img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ));?>" />
Title: <?php echo $post->post_title ?>
Parmalink: <a href="<?php echo get_permalink( $post->ID ); ?>">
Description: <?php echo substr($post->post_content, 0, 140);  ?>
Date: <?php echo get_the_time( 'F j, Y', $post->ID ) ?>
Commenet: <?php comments_popup_link('No Comments ', '1 Comment ', '% Comments '); ?>
Comment: <?php echo $post->comment_count; ?> or <?php echo get_comments_number( $post_id ); ?>
view: <?php echo getPostViews(get_the_ID()); ?>
Days Ago: <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?>
Auther: <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author(); ?></a><br>
<?php endwhile; ?>
  
<ul class="pagination">       
  <?php
    $big = 999999999; // need an unlikely integer
    echo paginate_links( array(
    'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
    'format' => '?paged=%#%',
    'current' => max( 1, get_query_var('paged') ),
    'total' => $loop->max_num_pages
    ) );
  ?>
</ul>
=======
Category:-
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

Tag:-
  <?php $tags = get_tags(); ?>
  <div class="tags">
  <?php foreach ( $tags as $tag ) { ?>
  <a href="<?php echo get_tag_link( $tag->term_id ); ?> " rel="tag"><?php echo $tag->name; ?></a>
  <?php } ?>

Search Bar:-
  <form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <div>
  <input type="text" value="" name="s" id="s" />
  <input type="submit" id="searchsubmit" value="Search" />
  </div>
  </form>
  =============
    Archive:-
    <?php wp_get_archives('type=alpha'); ?> //To display the *ALL* posts alphabetically
    <?php wp_get_archives( array( 'type' => 'yearly', 'limit' => 16) ); ?>
    <?php wp_get_archives( array( 'type' => 'monthly', 'limit' => 12 ) ); ?>   
    <?php wp_get_archives( array( 'type' => 'daily', 'limit' => 16) ); ?>
    
      <?php
global $wpdb;
$limit = 0;
$year_prev = null;
$months = $wpdb->get_results("SELECT DISTINCT MONTH( post_date ) AS month ,  YEAR( post_date ) AS year, COUNT( id ) as post_count FROM $wpdb->posts WHERE post_status = 'publish' and post_date <= now( ) and post_type = 'post' GROUP BY month , year ORDER BY post_date DESC");
foreach($months as $month) :
    $year_current = $month->year;
    if ($year_current != $year_prev){
        if ($year_prev != null){?>
         
        <?php } ?>
     
    <li class="archive-year"><a href="<?php bloginfo('url') ?>/<?php echo $month->year; ?>/"><?php echo $month->year; ?></a></li>
     
    <?php } ?>
    <li><a href="<?php bloginfo('url') ?>/<?php echo $month->year; ?>/<?php echo date("m", mktime(0, 0, 0, $month->month, 1, $month->year)) ?>"><span class="archive-month"><?php echo date_i18n("F", mktime(0, 0, 0, $month->month, 1, $month->year)) ?></span></a><?php echo $month->post_count; ?></li>
<?php $year_prev = $year_current;
 
if(++$limit >= 18) { break; }
 
endforeach; ?>
<style type="text/css">
        .widget-archive{padding: 0 0 40px 0; float: left; width: 235px;}
.widget-archive ul {margin: 0;}
.widget-archive li {margin: 0; padding: 0;}
.widget-archive li a{ border-left: 1px solid #d6d7d7; padding: 5px 0 3px 10px; margin: 0 0 0 55px; display: block;}
li.archive-year{float: left; font-family: Helvetica, Arial, san-serif; padding: 5px 0 3px 10px; color:#ed1a1c;}
li.archive-year a{color:#ed1a1c; margin: 0; border: 0px; padding: 0;}
      </style>
    
  <?php get_footer(); ?>
    
    
