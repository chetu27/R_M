<?php
error_reporting(0);
   /*
   Template Name: Product Add
   */ 

if (!is_user_logged_in()){ wp_redirect( home_url('login') ); }
get_header(); ?>
<?php 
  $getuserid =  get_current_user_id();

  session_start();
  require_once(dirname( __FILE__ ).'/../../../wp-config.php');
   
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


   if(isset($_POST['SubmitButton']))
   { 

      $barcode             = $_POST['barcode'];
      $product_name        = trim($_POST['product_name']);
      $types_of_pro        = $_POST['types_of_pro'];
      $product_description = $_POST['product_description'];
      $recipe              = implode(',', $_POST['recipe']); 
      $ingredients         = $_POST['ingredients'];
      $nutrition         = $_POST['nutrition'];



   $find_barcode = mysqli_query($conn, "SELECT barcode FROM wp_product where barcode = '$barcode' ");
  $find_product = mysqli_query($conn, "SELECT product_name FROM wp_product where product_name = '$product_name' "); 
   
      if(mysqli_num_rows($find_barcode) > 0){
      $barcodemsg = 'Barcode Already exists!';
   }else if(mysqli_num_rows($find_product) > 0){
      $product_msg = 'Product Already exists!';
   }else{
      $sql = "INSERT INTO wp_product (product_name,pro_cat, product_description,recipe,ingredients,barcode,user_id,nutrition) 
            VALUES ('$product_name','$types_of_pro', '$product_description', '$recipe', '$ingredients', '$barcode','$getuserid','$nutrition')";
          if (mysqli_query($conn, $sql)) {
            $_SESSION['msg1'] = "New Product created successfully !"; 
            wp_redirect( home_url('product-listing') ); 
          } else {
            echo "Error: " . $sql . "
      " . mysqli_error($conn);
          }
          mysqli_close($conn);
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
*
*/   
   if (isset($_GET['edit'])) {
      $id = $_GET['edit'];
      $update = true;
      $record = mysqli_query($conn, "SELECT * FROM wp_product WHERE id=$id");
      
         $fetch = mysqli_fetch_array($record);
         $barcode             = $fetch['barcode'];
         $product_name        = $fetch['product_name'];
         $types_of_pro        = $fetch['pro_cat'];
         $product_description = $fetch['product_description'];
         $Recipe_exp          = explode(',',$fetch['recipe']);
         $ingredients         = $fetch['ingredients'];
         $nutrition           = $fetch['nutrition'];  
   }

   if(isset($_POST['Updatebutton']))
   {
      //print_r($_POST);
      
      $id = $_POST['id'];

      $product_name        = trim($_POST['product_name']);
      $types_of_pro        = $_POST['types_of_pro'];
      $product_description = $_POST['product_description'];
      $recipe              = implode(',', $_POST['recipe']);
      $ingredients         = $_POST['ingredients'];
      $nutrition           = $_POST['nutrition'];


      mysqli_query($conn, "UPDATE wp_product SET product_name='$product_name', pro_cat='$types_of_pro' , product_description='$product_description', recipe='$recipe', ingredients='$ingredients', nutrition='$nutrition' WHERE id=$id");
      $_SESSION['msg1'] = "Product updated!"; 
      wp_redirect( home_url('product-listing') );

   


   }

/*
Show recipe Name In select box
*/ 
$reciperesult = mysqli_query($conn, "SELECT * FROM wp_recipe Where delete_at IS NULL AND status = '1'");
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
         </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
         <?php while($row = mysqli_fetch_assoc($reciperesult)){
         if(isset($_GET['edit'])){

             if (in_array($row["id"], $Recipe_exp)){ ?>  
            <option value="<?php echo $row["id"]; ?>" selected="selected" ><?php echo $row["recipe_name"]; ?></option>
            <?php }
            else
              { ?>
              <option value="<?php echo $row["id"]; ?>"><?php echo $row["recipe_name"]; ?></option>
              <?php }

         }else{ ?>
         <option value="<?php echo $row["id"]; ?>"><?php echo $row["recipe_name"]; ?></option>   
         <?php }
          } ?>
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
</script>