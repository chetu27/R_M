<?php
   /*
   Template Name: Recipe Add
   */ 
  if (!is_user_logged_in()){ wp_redirect( home_url('login') ); }
  get_header();
require_once('config.php');
session_start();
/*
Show Product Name In select box
*/ 
$result = mysqli_query($conn,"SELECT * FROM wp_product Where delete_at IS NULL AND status = '1'");

/* 
Recipe Insert 
*/ 
if(isset($_POST['SubmitButton']))
   { 
      global $wpdb;
      $recipe_table = "wp_recipe";

      $recipe             = trim($_POST['recipe']);
      $recipe_description = $_POST['recipe_description'];
      $product_name       = implode(',', $_POST['product_name']);  

      $find_recipe = $wpdb->get_results( "SELECT recipe_name FROM $recipe_table where recipe_name = '$recipe'");

      if(count($find_recipe) > 0){
         $recipe_msg = 'Recipe Already exists!';
      }else{
      $recipe_insert = $wpdb->insert( $recipe_table, array(
         'recipe_name'        => $recipe,
         'recipe_description' => $recipe_description,
         'product_list' => $product_name,
      ));
         // Last Insert ID
         $lastid = $wpdb->insert_id;
         // Insert Data into Product_Recipe Table
         $recipe_table = "wp_product_recipe";
         $product_name = $_POST['product_name'];
         foreach ($product_name as $key => $value) {
            $wpdb->insert( $recipe_table, array(
            'product_id'      => $value,
            'recipe_id'      => $lastid
            ));
        }
      }
      if(count($recipe_insert) > 0){
         $_SESSION['msg1'] = "New Recipe created successfully!";
         wp_redirect( home_url('recipe-list') );

      }         
   }
 /*
Edit recipe
*/ 
if (isset($_GET['edit'])) {
      $id = $_GET['edit'];
      $record = mysqli_query($conn, "SELECT * FROM wp_recipe WHERE id=$id");
      
         $fetch              = mysqli_fetch_array($record);
         $recipe             = $fetch['recipe_name'];
         $product_name       = $fetch['product_list']; 
         $recipe_description = $fetch['recipe_description']; 
         $product_nameexp    = explode(',',$fetch['product_list']);

   } 
/*
Edit Function
*/
if(isset($_POST['Updatebutton']))
{
  //print_r($_POST);  
  $id = $_POST['id'];
  $recipe             = trim($_POST['recipe']);
  $recipe_description = $_POST['recipe_description'];
  $product_name       = implode(',', $_POST['product_name']);
  
  
  global $wpdb;
  $recieName = $wpdb->get_var("SELECT recipe_name FROM wp_recipe where recipe_name = '$recipe' and id ='$id' ");
  $find_recipe = $wpdb->get_var("SELECT * FROM wp_recipe where recipe_name = '$recipe'");

  if($find_recipe > 0){    
    if($recieName == $recipe){

      $wpdb->query($wpdb->prepare(
          "UPDATE wp_recipe SET 
              recipe_name = '$recipe', 
              product_list = '$product_name',
              recipe_description = '$recipe_description'
              WHERE id = $id"
      ));
      
      $wpdb->query('DELETE FROM wp_product_recipe  WHERE recipe_id = "'.$id.'"');
      $recipe_table = "wp_product_recipe";
         foreach ($_POST['product_name'] as $key => $value) {
            $wpdb->insert( $recipe_table, array(
            'recipe_id'      => $id,
            'product_id'      => $value
            ));
         }

      $_SESSION['msg1'] = "Recipe updated!"; 
      wp_redirect( home_url('recipe-list') );
    }else{
        $recipe_msg = 'Recipe Already exists in you Database!';
    }  
  }else{
    $wpdb->query($wpdb->prepare(
          "UPDATE wp_recipe SET 
              recipe_name = '$recipe', 
              product_list = '$product_name',
              recipe_description = '$recipe_description'
              WHERE id = $id"
      ));
      $wpdb->query('DELETE FROM wp_product_recipe  WHERE recipe_id = "'.$id.'"');
      $recipe_table = "wp_product_recipe";
         foreach ($_POST['product_name'] as $key => $value) {
            $wpdb->insert( $recipe_table, array(
            'recipe_id'      => $id,
            'product_id'      => $value
            ));
         }
      $_SESSION['msg1'] = "Recipe updated!"; 
      wp_redirect( home_url('recipe-list') );
    }
}

$intendstr='';
if(isset($_GET['edit'])){
    $intendstr = ' and wpr.recipe_id='.$_GET["edit"];
}

$productResult = $wpdb->get_results( "SELECT wpr.product_id from wp_product_recipe as wpr JOIN wp_product as wp on wpr.product_id = wp.id where wp.delete_at IS NULL and wp.status = '1' ".$intendstr,ARRAY_A );
  foreach ($productResult as $key => $value) {
      $selectedProduct[]=$value['product_id'];
   }

$fetchProduct = $wpdb->get_results( "SELECT * FROM wp_product",ARRAY_A);
?>


<div class="container">
<form name="productform" id="productform" action="" method="post" enctype="multipart/form-data">
   <input type="hidden" name="id" value="<?php echo $id; ?>">
   <?php if (isset($_SESSION['message'])): ?>
   <div class="msg">
      <?php echo $msg; ?>
   </div>
   <?php endif ?>   
<!--    <button type="button" id="scanbarbutton" class="btn btn-danger">Scan Barcode</button> -->
   <div class="row">
   	 <div class="col-sm-12">
	   <div class="form-group">
	      <label>Recipe Name<span style="color:red;"> *</span></label>
	      <input type="text" class="form-control" id="recipe" name="recipe" placeholder="Enter Recipe Name" value="<?php echo $recipe; ?>" required maxlength="50" minlength="3">
        <span style="color:red;"><?php echo $recipe_msg; ?></span>
	   </div>
	  </div>
    <div class="col-sm-6">
      <div class="form-group">
      <label>Product Name<span style="color:red;"> *</span></label>
       <select class="form-control" id="product_name" name="product_name[]" multiple="multiple" required="" multiple data-live-search="true">
         <?php foreach ($fetchProduct as $key => $value) {
            if(isset($_GET['edit'])){
                $selected = '';
               if(in_array($value['id'], $selectedProduct)){
                     $selected = "selected='selected'";
               }
            }
         ?>
         <option value="<?php echo $value['id']; ?>"  <?php echo $selected; ?>><?php echo $value['product_name']; ?></option>
         <?php } ?>
    </select>
   </div>
    </div>
    <div class="col-sm-6 add-prduct-btn">
      <div class="form-group">
        <a href="<?php echo home_url('add-product'); ?>" target="_blank" class="btn btn-success">Add New Product</a>        
      </div>
    </div>
    <div class="col-sm-12">
      <div class="form-group">
        <label>Recipe Description</label>
        <textarea class="form-control" id="recipe_description" name="recipe_description" rows="3" maxlength="200" minlength="3"><?php echo $recipe_description; ?></textarea>        
      </div>
    </div>
	</div>

   

      <?php if(isset($_GET['edit'])){ ?>
         <input type="submit" name="Updatebutton" id="Updatebutton" class="btn btn-success" value="Update">
         <a href="<?php echo home_url('recipe-list'); ?>"><button type="button" class="btn btn-outline-secondar btn-info">Back</button></a>
      <?php } else { ?>
         <input type="submit" class="btn btn-success" name="SubmitButton" id="SubmitButton" value="Submit">
      <?php } ?>
      
</form>
</div>

<?php get_footer(); ?>
<script type="text/javascript">
  $('#SubmitButton, #Updatebutton').click(function(){
    var value =  $('#recipe').val();
    value = value.trim();
    if(value==''){
      $('#recipe').val(null);
    }
  });
</script>