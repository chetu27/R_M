<?php
/*
Plugin Name: Ajax Demo Plugin
Plugin URI: http://www.inkthemes.com
Description: My first ajax plugin
Version: 1.0
Author: InkThemes
Author URI: http://www.inkthemes.com
License: Plugin comes under GPL Licence.
*/
//Include Javascript library

wp_enqueue_script('fbag', plugins_url( '/js/demo.js' , __FILE__ ) , array( 'jquery' ));
// including ajax script in the plugin Myajax.ajaxurl
wp_localize_script( 'fbag', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php')));

/*
Ajax Function for Insert
*/ 
function insert_form(){
$pro_cat = $_POST['pro_category'];
global $wpdb;
$wpdb->insert( 
	'wp_product_cat', 
	array( 
		'cat_name' => $pro_cat
	));
die();
return true;
}
add_action('wp_ajax_insert_form', 'insert_form');
add_action('wp_ajax_nopriv_insert_form', 'insert_form');


/*
Ajax Function for Update
*/ 
function update_form(){
	$id = $_POST['id'];
	$pro_cat = $_POST['pro_category'];
	global $wpdb;
    $wpdb->query($wpdb->prepare("UPDATE wp_product_cat SET cat_name='$pro_cat' WHERE id = $id"));
	die();
	return true;
}
add_action('wp_ajax_update_form', 'update_form');
add_action('wp_ajax_nopriv_update_form', 'update_form');


/*
Shortcode Function for Insert Form
*/ 
function shortcode_insert_form() { ?>
<div class="container">  
	<div class="alert alert-success alert-dismissible" id="success" style="display:none;">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
	</div>
  
    <form type="post" action="" id="insertdata">
        <div class="row">
          <div class="form-group col-sm-6">
            <label>Product Categery<span style="color:red;"> *</span></label>
            <input type="text" id="pro_category" name="pro_category" class="form-control" placeholder="Enter Product Caregory" value="<?php echo $pro_cat; ?>" minlength="3" maxlength="10">      
          </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
            	<?php if(isset($_GET['edit'])){ ?>
		         <input type="button" name="Updatebutton" id="Updatebutton" class="btn btn-success" value="Update">
		        <?php } else { ?>
		           <input type='button' class="btn btn-primary" id='submit' name='submit' value='Submit'/>
		        <?php } ?>            	
            </div>
        </div>
    </form>
</div>
<br>
<?php } add_shortcode('show_form', 'shortcode_insert_form'); 


/*
Show Data From the DataBase
*/



function shortcode_view_table(){ 
  global $wpdb;
  $getProCat = $wpdb->get_results("SELECT * FROM wp_product_cat where delete_at IS NULL");
?>
<div class="container">
  <div class="">
    <div class="background-green-heading">
      <div class="col-sm-6 d-flex setCenter">
        <h2>Product Category List</h2>
    </div>

    <div class="clearfix"></div>
    </div>
  </div>

  <br>
  <table class="table table-hover" id="productc_list">
     <thead>
        <tr>
           <th scope="col">Product Category</th>
           <th scope="col">Action</th>
        </tr>
     </thead>
     <tbody>
  	<?php foreach($getProCat as $showProCat){ ?>
      <tr>
        <td><?php echo $showProCat->cat_name; ?></td>
        <td class="d-flex ml5"><a class="btn btn-primary btn-sm" href="k?edit=<?php echo $showProCat->id; ?>" class="edit_btn" >Edit</a>
           <a class="btn btn-danger btn-sm" href="k?del=<?php echo $showProCat->id; ?>" onClick="return confirm('Are you sure you want to delete?')" >Delete</a>
        </td>
      </tr>
  	<?php } ?>
        
     </tbody>
  </table>
</div>
<?php } add_shortcode('show_data', 'shortcode_view_table'); ?>

