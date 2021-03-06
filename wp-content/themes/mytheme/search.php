<?php get_header(); ?>

<div class="container">
	<h3>Seacrch Result For: <?php echo get_search_query(); ?></h3>
<div class="row">
<div class="col-sm-8">
		<?php if ( have_posts() ) : ?>

<header class="page-header">
	<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentysixteen' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
</header>
<?php if ( have_posts() ) : ?>
			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();

				the_title();
				the_content();

				// End the loop.
			endwhile; ?>
	
<?php else : ?>
						<h1> No Result Found</h1>

            <?php endif; ?>
			// Previous/next page navigation.
	<?php		the_posts_pagination(
				array(
					'prev_text'          => __( 'Previous page', 'twentysixteen' ),
					'next_text'          => __( 'Next page', 'twentysixteen' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
				)
			);

			// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
</div><div class="col-sm-4">
	<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <div>  
  <input type="text" value="" name="s" id="s" />
  <input type="submit" id="searchsubmit" value="Search" />
  </div>
  </form>
	<h3>Recent Post</h3>
<?php $args = array('post_type' => 'post','posts_per_page'=>-3,'post_status' => 'publish');
  $loop = new WP_Query( $args );
   while ( $loop->have_posts() ) : $loop->the_post();?>
	<h6><a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo $post->post_title ?></a></h6>
<?php endwhile; ?>	
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
<li  class="list-group-item"><a href="<?php echo home_url();?>/category/<?php echo $term_single->slug; ?>"><?php echo $term_single->name; ?></a></li>         
<?php } ?>
            </ul>
            </div>	

	</div></div></div>
		</main><!-- .site-main -->
	</section><!-- .content-area -->


<?php get_footer(); ?>
