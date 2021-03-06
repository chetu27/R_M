<?php
session_start();
/*
Template Name: Product Category
*/ 
require_once('config.php');
get_header();


if (isset($_GET['imsg'])) {
  $imsg = 1;
} 
if (isset($_GET['dmsg'])) {
  $dmsg = 1;
} 
if (isset($_GET['umsg'])) {
  $umsg = 1;
} 

if(isset($_POST['SubmitButton']))
  { 
    $cat_name = trim($_POST['pro_category']);

    $sql = "INSERT INTO wp_product_cat (cat_name) VALUES ('$cat_name')";
          if (mysqli_query($conn, $sql)) {
           // $_SESSION['msg1'] = "New Product Category successfully !"; 
           //$message = "New Product Category successfully!";
            wp_redirect( home_url('product-category?imsg=1') ); 
          }
  }

  global $wpdb;
  $getProCat = $wpdb->get_results("SELECT * FROM wp_product_cat where delete_at IS NULL");

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
              'cat_name' => trim($_POST['pro_category'])
              );
          $wherecondition=array(
                    'id'=>$id
                  );
        $wpdb->update($table, $data, $wherecondition);
        wp_redirect( home_url('product-category?umsg=1') );

}

if (isset($_GET['del'])) {
  $id = $_GET['del'];
    global $wpdb;
    $wpdb->query($wpdb->prepare("UPDATE wp_product_cat SET delete_at='$date' WHERE id = $id"));
    wp_redirect( home_url('product-category?dmsg=1') );


}

?>

<div class="container">
  <!-- Insert Message -->
    <?php if ($imsg): ?>
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    Product Category created successfully!
</div>
<?php endif; ?>
<!-- Delete measage -->
    <?php if ($dmsg): ?>
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    Product Category Delete successfully!
</div>
<?php endif; ?>
<!-- Update message -->
    <?php if ($umsg): ?>
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    Product Update Delete successfully!
</div>
<?php endif; ?>

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
<!-- <?php //if (isset($message)): ?><div class="updated"><p><?php //echo $message; ?></p></div><?php //endif; ?> -->

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
        <td class="d-flex ml5"><a class="btn btn-primary btn-sm" href="product-category?edit=<?php echo $showProCat->id; ?>" class="edit_btn" >Edit</a>
           <a class="btn btn-danger btn-sm" href="product-category?del=<?php echo $showProCat->id; ?>" onClick="return confirm('Are you sure you want to delete?')" >Delete</a>
        </td>
      </tr>
  <?php } ?>
        
     </tbody>
  </table>


</div>


<?php get_footer(); ?> 
<script type="text/javascript">
  $('#SubmitButton, #Updatebutton').click(function(){
    var value =  $('#pro_category').val();
    value = value.trim();
    if(value==''){
      $('#pro_category').val(null);
    }
  });
</script>
