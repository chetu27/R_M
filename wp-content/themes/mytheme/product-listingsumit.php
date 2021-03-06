<?php
    $inactive = 60; 
    ini_set('session.gc_maxlifetime', $inactive);
session_start();
/*
Template Name: Product Listing
*/ 
if (!is_user_logged_in())
 {  wp_redirect( home_url('login') ); }
get_header();


require_once(dirname( __FILE__ ).'/../../../wp-config.php');
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$date = date("Y-m-d H:i:s");

/*
Get The Data from the datbase
*/ 
$getuserid =  get_current_user_id();
$inActivebuttonHide = '';
$activebuttonHide = '';
if(isset($_POST['inactivatel']))
{
  $inActivebuttonHide = 'style="display: none !important"';
$result = mysqli_query($conn,"SELECT * FROM wp_product where user_id='$getuserid' AND status='0' AND delete_at IS NULL");
}else if(isset($_POST['activatel'])){
  $activebuttonHide = 'style="display: none !important"';
$result = mysqli_query($conn,"SELECT * FROM wp_product where user_id='$getuserid' AND status='1' AND delete_at IS NULL");
}else{
  $activebuttonHide = 'style="display: none !important"';
  $result = mysqli_query($conn,"SELECT * FROM wp_product where user_id='$getuserid' AND status='1' AND delete_at IS NULL");

}


/*
Delete Function for 1 row.
*/ 
if (isset($_GET['del'])) {
   $id = $_GET['del'];
  // mysqli_query($conn, "DELETE FROM wp_product WHERE id=$id");
  // $_SESSION['msg1'] = "Product deleted!"; 
  // wp_redirect( home_url('product-listing'));
    $deletepro = mysqli_query($conn, "UPDATE wp_product SET delete_at='$date' WHERE id=$id"); 
    if($deletepro) {
      $_SESSION['msg1'] = "Product Delete successfully !";
      wp_redirect( home_url('product-listing') );
      
   }
}

/*
Delete Multipal rows Function.
*/ 
if(isset($_POST['delete']))
{
  $checkbox=$_POST['deletecheck'];
  foreach ($checkbox as $value)
  {
    // mysqli_query($conn, "DELETE FROM wp_product WHERE id='$value'");
    mysqli_query($conn, "UPDATE wp_product SET delete_at='$date' WHERE id=$value");
    wp_redirect( home_url('product-listing') );
}
}

if(isset($_POST['active']))
{
 // print_r($_POST);die;
  $checkbox=$_POST['deletecheck'];
  foreach ($checkbox as $value)
  {
   // $status = $fetch['status'];Active 
    if($_POST['active'] == 'Active'){
      $statusUpdate = 1;
  }else{
      $statusUpdate = 0;
  }
  mysqli_query($conn, "UPDATE wp_product SET status='$statusUpdate' WHERE id='$value'");
  wp_redirect( home_url('product-listing') );
}
}

if(isset($_POST['inactivate']))
{
  // print_r($_POST['deactivate']);
  // die();
  $checkbox=$_POST['deletecheck'];
  foreach ($checkbox as $value)
  {
        // print_r($value);die;
        // $status = $fetch['status'];

    if($_POST['inactivate'] == 'Inactivate'){
      $statusUpdate = 0;
  }else{
      $statusUpdate = 1;
  }
  mysqli_query($conn, "UPDATE wp_product SET status='$statusUpdate' WHERE id='$value'");
  wp_redirect( home_url('product-listing') );
  }
}
//echo $_SESSION['msg1'];
?>


<div class="container">
  <?php if (isset($_SESSION['msg1'])): ?>
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php 
    $_SESSION['timeout'] = time();
//     echo $_SESSION['msg1']; 

// if (isset($_SESSION['msg1']) && (time() - $_SESSION['msg1'] < $inactive)) {
//     // last request was more than 2 hours ago
//     session_unset();     // unset $_SESSION variable for this page
//     session_destroy();   // destroy session data
// }
// $_SESSION['msg1'] = 'askgflag kagj a ahsf '; // Update session
//     //unset($_SESSION['msg1']);        
 if ($_SESSION['timeout'] + 60 > time()) {
     unset($_SESSION['msg1']);
  } else {
     echo $_SESSION['msg1'];
  }

    ?>
</div>
<?php endif; ?>
<form action="#" method="post">
    <div class="">
      <div class="background-green-heading">
        <div class="col-sm-6 d-flex setCenter">
          <h2>Product <b>List</b> 

            <input class="btn btn-danger" name="inactivatel" type="submit" id="inactivatel" value="View InActivate Product" <?php echo $inActivebuttonHide; ?>> 
            <input class="btn btn-danger" name="activatel" type="submit" id="activatel" value="View Activate Product" <?php echo $activebuttonHide; ?>>
          </h2>
      </div>
      <div class="col-sm-6 text-right setCenter">    
           <!--  <select>
                <option>-- Select Action --</option>
                <option>Delete</option>
                <option>Active</option>
                <option>Inactivate</option>
                
            </select> -->
          
          <input class="btn btn-danger" name="delete" type="submit" id="delete" value="Delete" onClick="return confirm('Are you sure you want to delete?')" disabled='disabled'>

          <input class="btn btn-danger" <?php echo $activebuttonHide; ?> name="active" type="submit" id="active" value="Active" onClick="return confirm('Are you sure you want to Active?')" disabled='disabled'>
          
          <input class="btn btn-danger" <?php echo $inActivebuttonHide; ?> name="inactivate" type="submit" id="inactivate" value="Inactivate" onClick="return confirm('Are you sure you want to Deactivate?')" disabled='disabled'>       

      </div>
      <div class="clearfix"></div>
  </div>
</div>
<div class="table-responsive">
<table class="table table-hover" id="product_list">
  <thead>
    <tr>
      <th class="nosort"><span class="custom-checkbox">
        <input type="checkbox" id="selectAll" name="selectAll">
        <label for="selectAll"></label>
    </span>
</th>
<th scope="col">BarCode Number</th>
<th scope="col">Product Name</th>
<th scope="col">Recipe</th>
<th scope="col">Ingredients</th>
<th scope="col">Created</th>
<th scope="col">Action</th>
</tr>
</thead>
<tbody>
  <?php
  $count=1;
  if ($result->num_rows > 0) {
   while($row = $result->fetch_assoc()) { 
     //echo "<pre>"; print_r($row);
     unset($test1);
     $recipe_list = explode(',',$row["recipe"]);
     foreach ($recipe_list as $value) {     

      $result123 = mysqli_query($conn,"SELECT * FROM wp_recipe where id = $value");
      $row12 = mysqli_fetch_assoc($result123); 
      $test1[] = $row12["recipe_name"];   
  }
// {{ $ipoper->in_interface === null ? "--" : $ipoper->in_interface}}

  ?> 
  <tr>
      <th><span class="custom-checkbox">
        <input name="deletecheck[]" type="checkbox" id="checkbox1" class="checkbox1" value="<?php echo $row["id"];?>">
        <label for="checkbox1"></label>
    </span>
</th>
<td><?php echo $row["barcode"]; ?></td>
<td><?php if($row["product_name"] == null){ echo "- -"; }else{echo $row["product_name"];}  ?></td>
<td><?php if(implode(', ',$test1) == null){ echo "- -"; }else{echo implode(', ',$test1);} ?></td>
<td><?php if($row["ingredients"] == null){ echo "- -"; }else{echo $row["ingredients"];}  ?></td> 
<td><?php echo date("d-m-Y", strtotime($row["created_at"])); ?></td>
<td class="d-flex ml5"><a class="btn btn-primary btn-sm" href="add-product?edit=<?php echo $row['id']; ?>" class="edit_btn" >Edit</a>
  <a class="btn btn-danger btn-sm" href="product-listing?del=<?php echo $row['id']; ?>" onClick="return confirm('Are you sure you want to delete?')" >Delete</a>    
  <!-- <button type="button" class="btn btn-danger btn-sm">Delete</button> -->
  <i data="<?php echo $row['id'];?>" class="status_checks_pro btn
  <?php echo ($row["status"])?
  'btn-success': 'btn-danger'?>"><?php echo ($row["status"])? 'Active' : 'Inactive'?>
</i>
</td>
</tr>
<?php  } } else {  ?>
  <tr>
    <td colspan="7" style="text-align: center;">No Result Found</td>
</tr>
<?php }  ?>
</tbody>
</table>
</div>
</form>
</div>
<?php get_footer(); ?> 
