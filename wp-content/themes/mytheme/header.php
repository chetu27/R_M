<?php error_reporting(0); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php if (is_front_page() ) { bloginfo('name'); } else { wp_title(''); ?> | <?php bloginfo('name'); } ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">

</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <?php the_custom_logo(); ?><?php bloginfo( 'name' ); ?>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
  <!--   <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Page 1-1</a></li>
          <li><a href="#">Page 1-2</a></li>
          <li><a href="#">Page 1-3</a></li>
        </ul>
      </li>
      <li><a href="#">Page 2</a></li>
    </ul> -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav navbar-right">
      <!-- <li><a href="#">Page 1-1</a></li>
      <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li> -->


<?php if( is_user_logged_in() ) { ?>
    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Product <span class="caret"></span></a>
        <ul class="dropdown-menu donwBg">
          <li><a href="<?php echo home_url('add-product'); ?>" class=" dropdown-item">Add Product</a></li>
          <li><a href="<?php echo home_url('product-listing'); ?>" class=" dropdown-item">Product Listing</a></li>
          <li><a href="<?php echo home_url('product-category'); ?>" class=" dropdown-item">Product Category</a></li>
        </ul>
    </li>

    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Recipe <span class="caret"></span></a>
        <ul class="dropdown-menu donwBg">
          <li><a href="<?php echo home_url('recipe-add'); ?>" class=" dropdown-item">Add Recipe</a></li>
          <li><a href="<?php echo home_url('recipe-list'); ?>" class=" dropdown-item">Recipe Listing</a></li>
        </ul>
    </li>
    <?php $current_user = wp_get_current_user(); ?>
    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo ucfirst($current_user->user_login); ?><span class="caret"></span></a>
        <ul class="dropdown-menu donwBg">
          <li><a href="<?php echo wp_logout_url(); ?>" class=" dropdown-item">Logout</a></li>
        </ul>
    </li>
<?php } ?>
    </ul>
     <?php 
 // if(is_user_logged_in()){
 //               wp_nav_menu([
 //             'menu'            => 'header-menu',
 //             'theme_location'  => 'top',
 //             'container'       => 'ul',
 //             'container_id'    => 'bs4navbar',
 //             'container_class' => '',
 //             'menu_id'         => false,
 //             'menu_class'      => 'nav navbar-nav navbar-right',
 //             'depth'           => 2,
 //             'fallback_cb'     => 'bs4navwalker::fallback',
 //             'walker'          => new bs4navwalker()
 //           ]);
 //      }else{
 //             wp_nav_menu([
 //           'menu'            => 'logout-menu',
 //           'theme_location'  => 'top',
 //           'container'       => 'div',
 //           'container_id'    => 'bs4navbar',
 //           'container_class' => '',
 //           'menu_id'         => false,
 //           'menu_class'      => 'nav navbar-nav navbar-right',
 //           'depth'           => 2,
 //           'fallback_cb'     => 'bs4navwalker::fallback',
 //           'walker'          => new bs4navwalker()
 //         ]);
 //      }

   ?>
  </div>
  </div>
</nav>




<div class="content-section">

<?php wp_head(); ?>
