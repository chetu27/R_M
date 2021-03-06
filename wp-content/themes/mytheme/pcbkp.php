<?php
session_start();
/*
Template Name: Product Category
*/ 
require_once('config.php');
get_header(); 
if(isset($_POST['SubmitButton']))
  { 
    $cat_name = $_POST['pro_category'];

    $sql = "INSERT INTO wp_product_cat (cat_name) VALUES ('$cat_name')";
          if (mysqli_query($conn, $sql)) {
           // $_SESSION['msg1'] = "New Product Category successfully !"; 
           $message = "New Product Category successfully!";
            //wp_redirect( home_url('product-category') ); 
          }
  }

  global $wpdb;
  $getProCat = $wpdb->get_results("SELECT * FROM wp_product_cat");

  if (isset($_GET['edit'])){
      $id = $_GET['edit'];
      $retriveProCat = $wpdb->get_results("SELECT * FROM wp_product_cat WHERE id=$id");
      foreach($retriveProCat as $showProCat){
          $pro_cat = $showProCat->cat_name;
      }
  }


if(isset($_POST['Updatebutton']))
{
 
   $id = $_POST['id'];
   $table= 'wp_product_cat';
   //$pro_cat = trim($_POST['pro_category']);

   global $wpdb;
   $data =array(
              'cat_name' => $_POST['pro_category']
              );
          $wherecondition=array(
                    'id'=>$id
                  );
        $wpdb->update($table, $data, $wherecondition);
        wp_redirect( home_url('product-category') );

}

if (isset($_GET['del'])) {
  $id = $_GET['del'];
  global $wpdb;
  $wpdb->query($wpdb->prepare("DELETE FROM wp_product_cat WHERE id = $id"));
  wp_redirect( home_url('product-category') );
}

?>

<div class="container">
 <?php if (isset($_SESSION['msg1'])): ?>
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php 
    echo $_SESSION['msg1'];
    echo $message;
   // unset($_SESSION['msg1']);
   //session_destroy($_SESSION['msg1']);           
    ?>
</div>
<?php unset($_SESSION['msg1']); endif; ?>

<!-- Form For Product Category -->
  <form name="pcategoryform" id="pcategoryform" action="" method="post">
   <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="row">
      <div class="col-lg-6">
        <label>Product Categery<span style="color:red;"> *</span></label>
            <input id="pro_category" name="pro_category" class="form-control" placeholder="Enter Product Caregory" type="text"  value="<?php echo $pro_cat; ?>" required/> 
            <span style="color:red;"><?php //echo $barcodemsg; ?></span>
      </div>
      <div class="col-lg-6 add-prduct-btn">
        <span class="input-group-btn"> 
          <?php if(isset($_GET['edit'])){ ?>
         <input type="submit" name="Updatebutton" id="Updatebutton" class="btn btn-success" value="Update">
        <?php } else { ?>
           <input type="submit" id="SubmitButton" class="btn btn-success" name="SubmitButton" value="Submit">
        <?php } ?>





          
        </span>
      </div>
    </div>
  </form>



  <!-- Product Category Listing -->
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
        <td class="d-flex ml5"><a class="btn btn-primary btn-sm" href="product-category?edit=<?php echo $showProCat->id; ?>" class="edit_btn" >Edit</a>
           <a class="btn btn-danger btn-sm" href="product-category?del=<?php echo $showProCat->id; ?>" onClick="return confirm('Are you sure you want to delete?')" >Delete</a>
        </td>
      </tr>
  <?php } ?>
        
     </tbody>
  </table>


</div>


<?php get_footer(); ?> 
