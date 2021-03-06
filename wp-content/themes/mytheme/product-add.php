<?php
error_reporting(0);
   /*
   Template Name: Product Add
   */ 
get_header(); 
require_once('config.php');
session_start();   

   if(isset($_POST['SubmitButton']))
   {  
      global $wpdb;
      $product_table = "wp_product";

      $source_path = $_FILES['fileToUpload']['tmp_name'];
      $name = $_FILES['fileToUpload']['name'];
      $rand = time().'_';
      $des_path =ABSPATH."wp-content/themes/mytheme/img/" . $rand.$name;
      move_uploaded_file($source_path,$des_path);
      $img = $rand.$name;
      $barcode             = $_POST['barcode'];
      $product_name        = trim($_POST['product_name']);
      $types_of_pro        = $_POST['types_of_pro'];
      $product_description = $_POST['product_description'];
      $recipe              = implode(',', $_POST['recipe']); 
      $ingredients         = $_POST['ingredients'];
      $nutrition           = $_POST['nutrition'];


      $find_barcode = $wpdb->get_results( "SELECT barcode FROM $product_table where barcode = '$barcode'");
      $find_product = $wpdb->get_results( "SELECT product_name FROM $product_table where product_name = '$product_name'");

      if(count($find_barcode) > 0){
         $barcodemsg = 'Barcode Already exists!';
      }else if(count($find_product) > 0){
         $product_msg = 'Product Already exists!';
      }else{
         $sql = $wpdb->insert( $product_table, array(
         'user_id'      => $getuserid,
         'barcode'      => $barcode,
         'product_name' => $product_name,
         'pro_cat'      => $types_of_pro,
         'product_description' => $product_description,
         'recipe'       => $recipe,
         'nutrition'    => $nutrition,
         'ingredients'  => $ingredients,
         'pro_img'      => $img
      ));
         // Last Insert ID
         $lastid = $wpdb->insert_id;
         // Insert Data into Product_Recipe Table
         $recipe_table = "wp_product_recipe";
         $recipe1 = $_POST['recipe'];
         foreach ($recipe1 as $key => $value) {
            $wpdb->insert( $recipe_table, array(
            'product_id'      => $lastid,
            'recipe_id'      => $value
            ));
         }
      if(count($sql) > 0){
         $_SESSION['msg1'] = "New Product created successfully !"; 
         wp_redirect( home_url('product-listing') );

      }

      }


   }
      
/*
* Hide Sacn Barcode Button
* Disable barcode text field
*/ 
   if(isset($_GET['edit'])){ ?>
            <script type="text/javascript">
               jQuery(document).ready(function($) {
                  $('#scanner_input').attr('readonly', true);
                  $("#scanbarbutton").hide();
               });
            </script>
            <style type="text/css">
              input#scanner_input {
                  cursor: not-allowed;
              }
            </style>
   <?php } 
 /*
* Fetch The Data From
*/   
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $record = $wpdb->get_results( "SELECT * FROM wp_product where id=$id");
  foreach ($record as $key => $value) {
    $barcode              = $value->barcode;
    $product_name         = $value->product_name;
    $types_of_pro         = $value->pro_cat;
    $product_description  = $value->product_description;
    $Recipe_exp           = explode(',',$value->recipe);
    $ingredients          = $value->ingredients;
    $nutrition            = $value->nutrition;
    $img_path             = home_url().'/wp-content/themes/mytheme/img/'.$value->pro_img;
  }
}

   if(isset($_POST['Updatebutton']))
   {
      $id = $_POST['id'];

      $source_path = $_FILES['fileToUpload']['tmp_name'];
      $name = $_FILES['fileToUpload']['name'];
      $find_img = mysqli_query($conn, "SELECT pro_img FROM wp_product where id = '$id'");
      $product_img = mysqli_fetch_array($find_img);

      if( $name ==""){         
         $img = $product_img['pro_img'];
      }else{
         $rand = time().'_';
         $des_path =ABSPATH."wp-content/themes/mytheme/img/" . $rand.$name;
         move_uploaded_file($source_path,$des_path);
         $img = $rand.$name;
         unlink(ABSPATH."wp-content/themes/mytheme/img/" . $product_img['pro_img']);
      }
      $product_name        = trim($_POST['product_name']);
      $types_of_pro        = $_POST['types_of_pro'];
      $product_description = $_POST['product_description'];
      $recipe              = implode(',', $_POST['recipe']);
      $ingredients         = $_POST['ingredients'];
      $nutrition           = $_POST['nutrition'];

      global $wpdb;

      $proUpdate = $wpdb->query($wpdb->prepare(
          "UPDATE wp_product SET 
              product_name = '$product_name', 
              pro_cat = '$types_of_pro',
              product_description = '$product_description',
              recipe = '$recipe',
              ingredients = '$ingredients',
              nutrition = '$nutrition',
              pro_img = '$img'
              WHERE id = $id"
      ));        
       
      $wpdb->query('DELETE  FROM wp_product_recipe  WHERE product_id = "'.$id.'"');

         $recipe_table = "wp_product_recipe";
         foreach ($_POST['recipe'] as $key => $value) {
            $wpdb->insert( $recipe_table, array(
            'product_id'      => $id,
            'recipe_id'      => $value
            ));
         }
      if(count($proUpdate) > 0){
         $_SESSION['msg1'] = "Product updated!"; 
         wp_redirect( home_url('product-listing') );
      }
      

       

   }

   function getrecipiesDetails($product_id){
      global $wpdb;
      $DbResult=array();
      $result = $wpdb->get_results("SELECT id,recipe_id FROM `wp_product_recipe` WHERE product_id=$product_id ");
     foreach (json_decode(json_encode($result), true) as $value) {
         $DbResult[$value['id']]=$value['recipe_id'];
     }
      return $DbResult;
   }

/*
Show recipe Name In select box
*/ 
$intendstr='';
if(isset($_GET['edit'])){
   $intendstr = ' and wpr.product_id='.$_GET["edit"];
}

$reciperesult1 = $wpdb->get_results( "SELECT wpr.recipe_id FROM wp_product_recipe as wpr JOIN wp_recipe as wr ON wpr.recipe_id=wr.id where wr.delete_at IS NULL and wr.status = '1' ".$intendstr,ARRAY_A ); 
   foreach ($reciperesult1 as $key => $value) {
      $selectedrecipes[]=$value['recipe_id'];
   }
/*
Fetch The All Recipe
*/
$fetchrecipe = $wpdb->get_results( "SELECT * FROM wp_recipe",ARRAY_A);

?>


<?php
// die();

$pro_cat_result = mysqli_query($conn, "SELECT * FROM wp_product_cat Where delete_at IS NULL");


?>

<div class="container">
   <form name="productform" id="productform" action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <div class="row">
         <div class="col-lg-6">
            <label>Barcode Number<span style="color:red;"> *</span></label>
            <input id="scanner_input" name="barcode" class="form-control" placeholder="Enter BarCode OR Scan Barcode" type="number" step="0" value="<?php echo $barcode; ?>" required/> 
            <span style="color:red;"><?php echo $barcodemsg; ?></span>
         </div>
         <div class="col-lg-6 add-prduct-btn">
            <span class="input-group-btn"> 
            <button class="btn btn-danger" id="scanbarbutton" type="button" data-toggle="modal" data-target="#livestream_scanner">
            <i class="fa fa-camera "> Scan Barcode</i>
            </button> 
            </span>
         </div>
      </div>
      <div class="modal" id="livestream_scanner">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title">Barcode Scanner</h4>
               </div>
               <div class="modal-body" style="position: static">
                  <div id="interactive" class="viewport"></div>
                  <div class="error"></div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
               </div>
            </div>
            <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <div class="row">
         <div class="col-md-12">
            <label>Product Name<span style="color:red;"> *</span></label>
            <input type="text" required class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name" value="<?php echo $product_name; ?>" maxlength="50" minlength="3">
            <span style="color:red;"><?php echo $product_msg; ?></span>
         </div>
      </div>
      <div class="row">
         <div class="col-md-6">
            <label>Product Category</label>
            <select class="form-control" id="types_of_pro" name="types_of_pro">
               <option value="">-- Product Category --</option>
               <!-- pro_cat_result -->
               <?php while($row = mysqli_fetch_assoc($pro_cat_result)){ 
                  if(isset($_GET['edit'])){ ?>
               <option value="<?php echo $row["id"]; ?>" <?php if($row["id"] == $types_of_pro){?> selected="selected" <?php } ?>><?php echo $row["cat_name"]; ?></option>
               <?php } else{ ?>
               <option value="<?php echo $row["id"]; ?>"><?php echo $row["cat_name"]; ?></option>
               <?php } } ?>
            </select>
         </div>
         <div class="col-md-6">
            <label>Recipe</label>
     <select class="form-control" id="recipe" name="recipe[]" multiple="multiple" multiple data-live-search="true">

         <?php foreach ($fetchrecipe as $key => $value) {
            if(isset($_GET['edit'])){
                $selected = '';
               if(in_array($value['id'], $selectedrecipes)){
                     $selected = "selected='selected'";
               }
            }
         ?>
         <option value="<?php echo $value['id']; ?>"  <?php echo $selected; ?>><?php echo $value['recipe_name']; ?></option>
         <?php } ?>


</select>
         </div>
      </div>
      <div class="row">
         <div class="col-md-6">
            <div class="form-group">
               <label>Nutrition</label>
               <input type="text" class="form-control" id="nutrition" name="nutrition" placeholder="Enter Nutrition Name" value="<?php echo $nutrition; ?>" maxlength="50" minlength="3">
            </div>
         </div>
         <div class="col-md-6">
            <div class="form-group">
               <label>Ingredients</label>
               <input type="text" class="form-control" id="ingredients" name="ingredients" placeholder="Enter Ingredients Name" value="<?php echo $ingredients; ?>" maxlength="50" minlength="3">
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <label>Product Description</label>
            <textarea class="form-control" id="product_description" name="product_description" rows="3" maxlength="200" minlength="3"><?php echo $product_description; ?></textarea>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <label>Product Image</label>
            <input type='file' name="fileToUpload" id="fileToUpload" accept="image/x-png,image/gif,image/jpeg" onchange="readURL(this);" />
            <?php if($img_path != home_url().'/wp-content/themes/mytheme/img/'.$value->pro_img){?>
            <img id="blah" src="<?php echo $img_path; ?>">
          <?php }else{ ?>
            <img id="blah">
          <?php }?>
         </div>
      </div>
      <br>
      <div class="row">
         <div class="col-md-12">
            <?php if(isset($_GET['edit'])){ ?>
            <input type="submit" class="btn btn-success" name="Updatebutton" id="Updatebutton" value="Update">
            <a href="<?php echo home_url('product-listing'); ?>"><button type="button" class="btn btn-outline-secondary btn-info">Back</button></a>
            <?php } else { ?>
            <input type="submit" id="SubmitButton" class="btn btn-success" name="SubmitButton" value="Submit">
            <?php } ?>
         </div>
      </div>
   </form>
</div>

<?php get_footer(); ?>
<script type="text/javascript">
  $('#SubmitButton, #Updatebutton').click(function(){
    var value =  $('#product_name').val();
    value = value.trim();
    if(value==''){
      $('#product_name').val(null);
    }
  });


     function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

</script>