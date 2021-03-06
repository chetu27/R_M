<?php
/* Template Name: Home */
if (!is_user_logged_in()){ wp_redirect( home_url('login') ); }
get_header(); 
global $wpdb;
$getuserid =  get_current_user_id();


$show_pro_count = $wpdb->get_results("SELECT COUNT(*) as num_rows FROM " . $wpdb->prefix . "product WHERE status='1' AND user_id='$getuserid'"); 
$show_rec_count = $wpdb->get_results("SELECT COUNT(*) as num_rows FROM " . $wpdb->prefix . "recipe WHERE status='1' "); 
?>


<div class="container">

<div class="row">
	<!-- <div class="col-sm-1"></div> -->
  <div class="col-sm-6 ">
  	<a href="<?php echo site_url('add-product'); ?>"><div class="boxes">
  Add Product</div></a></div>
  <!-- <div class="col-sm-1"></div> -->
  <div class="col-sm-6"><a href="<?php echo site_url('product-listing'); ?>"><div class="boxes">Product Listing<span> (<?php echo $show_pro_count[0]->num_rows; ?>)</span></div></a> </div>
</div>

<div class="row">
	<!-- <div class="col-sm-1"></div> -->
  <div class="col-sm-6 ">
  	<a href="<?php echo site_url('recipe-add'); ?>"><div class="boxes">
  Add Recipe</div></a></div>
  <!-- <div class="col-sm-1"></div> -->
  <div class="col-sm-6"><a href="<?php echo site_url('recipe-list'); ?>"><div class="boxes">Recipe Listing<span> (<?php echo $show_rec_count[0]->num_rows; ?>)</span></div></a> </div>
</div>

</div>

<?php get_footer(); ?>
