<?php
/*
Template Name: Recipe Listing
*/ 
require_once('config.php');
get_header();



/*
Get The Data from the datbase
*/ 
$getuserid =  get_current_user_id();

$inActivebuttonHide = '';
$activebuttonHide = '';
if(isset($_POST['inactivatel']))
{
  $inActivebuttonHide = 'style="display: none !important"';
$result = mysqli_query($conn,"SELECT * FROM wp_recipe where status='0' AND delete_at IS NULL");
}else if(isset($_POST['activatel'])){
  $activebuttonHide = 'style="display: none !important"';
$result = mysqli_query($conn,"SELECT * FROM wp_recipe where status='1' AND delete_at IS NULL");
}else{
  $activebuttonHide = 'style="display: none !important"';
  $result = mysqli_query($conn,"SELECT * FROM wp_recipe where status='1' AND delete_at IS NULL");

}




//$result = mysqli_query($conn,"SELECT * FROM wp_recipe where status='0' AND delete_at IS NULL");


/*
Delete Function
*/ 
$msg = 0;

if (isset($_GET['msg'])) {
  $msg = 1;
}
if (isset($_GET['del'])) {
  $id = $_GET['del'];
  //mysqli_query($conn, "DELETE FROM wp_recipe WHERE id=$id");
  mysqli_query($conn, "UPDATE wp_recipe SET delete_at='$date' WHERE id=$id");
  $_SESSION['msg1'] = "Recipe deleted!"; 
  $message = "Recipe deleted";
  wp_redirect( home_url('recipe-list?msg=1') );
}

/*
Delete Multipal rows Function
*/ 
if(isset($_POST['delete']))
{
  $checkbox=$_POST['deletecheck'];
  foreach ($checkbox as $value)
  {
    //mysqli_query($conn, "DELETE FROM wp_recipe WHERE id='$value'");
    mysqli_query($conn, "UPDATE wp_recipe SET delete_at='$date' WHERE id=$value");
    wp_redirect( home_url('recipe-list') );
  }
}
/*
Status Are Active
*/
if(isset($_POST['active']))
{

  $checkbox=$_POST['deletecheck'];
  foreach ($checkbox as $value)
  {
    if($_POST['active'] == 'Active'){
      $statusUpdate = 1;
    }else{
        $statusUpdate = 0;
    }
  mysqli_query($conn, "UPDATE wp_recipe SET status='$statusUpdate' WHERE id='$value'");
  wp_redirect( home_url('recipe-list') );
  }
}
/*
Status Are InActive
*/
if(isset($_POST['inactivate']))
{
  $checkbox=$_POST['deletecheck'];
  foreach ($checkbox as $value)
  {
    if($_POST['inactivate'] == 'Inactivate'){
      $statusUpdate = 0;
    }else{
        $statusUpdate = 1;
    }
  mysqli_query($conn, "UPDATE wp_recipe SET status='$statusUpdate' WHERE id='$value'");
  wp_redirect( home_url('recipe-list') );
  }
}


?>

<div class="container">
  <?php if ($msg): ?>
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    Recipe Delete successfully
    
</div>
<?php endif; ?>
<?php if (isset($_SESSION['msg1'])): ?>
<div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <?php 
      echo $_SESSION['msg1']; 
    ?>
</div>
<?php endif; unset($_SESSION['msg1']);?>
<form action="#" method="post">
<div class="">
  <div class="background-green-heading">
  <div class="col-sm-6 setCenter">
    <h2>Recipe <b>List</b>

      <input class="btn btn-danger" name="inactivatel" type="submit" id="inactivatel" value="View InActive Recipe" <?php echo $inActivebuttonHide; ?>> 
      <input class="btn btn-success" name="activatel" type="submit" id="activatel" value="View Active Recipe" <?php echo $activebuttonHide; ?>>

    </h2>
  </div>
  <div class="col-sm-6 text-right setCenter"> 
      
  <input class="btn btn-danger" <?php echo $activebuttonHide; ?> name="active" type="submit" id="active" value="Active" onClick="return confirm('Are you sure you want to Active?')" disabled='disabled'>

  <input class="btn btn-danger" <?php echo $inActivebuttonHide; ?> name="inactivate" type="submit" id="inactivate" value="Inactivate" onClick="return confirm('Are you sure you want to Deactivate?')" disabled='disabled'>     

    <input class="btn btn-danger" name="delete" type="submit" id="delete" value="Delete" onClick="return confirm('Are you sure you want to delete?')" disabled='disabled'>         
  </div>
  <div class="clearfix"></div>
  </div>
</div>
<div class="table-responsive">
<table class="table table-hover" id="recipe_list">
  <thead>
    <tr>
      <th class="remove-sorting-icon">
        <span class="custom-checkbox">
          <input type="checkbox" id="selectAll" name="selectAll">
          <label for="selectAll"></label>
        </span>
      </th>
      <th scope="col">Recipe Name</th>
      <th scope="col">Product List</th>
      <th scope="col">Created</th>
      <th class="remove-sorting-icon" scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $count=1;
   if ($result->num_rows > 0) {
   while($row = $result->fetch_assoc()) {

    $findProductList =$wpdb->get_results("SELECT wpr.recipe_id, GROUP_CONCAT(wpr.product_id) as product_id FROM wp_product_recipe as wpr WHERE wpr.recipe_id IN ('".$row['id']."') GROUP BY wpr.recipe_id");
   $productName = $wpdb->get_results("SELECT * FROM `wp_product` WHERE `id` IN (". $findProductList[0]->product_id .") ORDER BY `product_name` ASC");

    ?> 
    <tr>
      <!-- <th scope="row"><?php echo $count++; ?></th> -->
      <td>
        <span class="custom-checkbox">
          <!-- <input type="checkbox" id="checkbox1" class="checkbox1" name="options[]" value="1"> -->
          <input name="deletecheck[]" type="checkbox" id="checkbox1" class="checkbox1" value="<?php echo $row["id"];?>">
          <label for="checkbox1"></label>
        </span>
      </td>

      <td><?php echo $row["recipe_name"]; ?></td>


      <td><?php foreach ($productName as $key => $value) {
      if($key==0){
       echo $dff = $value->product_name;
      }else{
        echo ', '.$value->product_name;
      }
     }
     ?>      </td> 


      <td><?php echo date("d-m-Y", strtotime($row["created_at"])); ?></td>

      <td class="d-flex ml5"><a class="btn btn-primary btn-sm" href="recipe-add?edit=<?php echo $row['id']; ?>" class="edit_btn" >Edit</a>
        <a class="btn btn-danger btn-sm" href="recipe-list?del=<?php echo $row['id']; ?>" onClick="return confirm('Are you sure you want to delete?')" class="del_btn">Delete</a> 
        <i data="<?php echo $row['id'];?>" class="status_checks btn
         <?php echo ($row["status"])?'btn-success': 'btn-danger'?>"> <?php echo ($row["status"])? 'Active' : 'Inactive'?>
     </i>   
        </td>
    </tr>
  <?php  } } else { ?>
    <tr>
        <td colspan="7" style="text-align: center;">No Result Found</td>
      </tr>
    <?php  }  ?>
  </tbody>
</table>
</div>
</form>
</div>

<?php get_footer(); ?> 
<script>
      $( document ).ready(function() {
    console.log( "ready!" );
    setTimeout(function (){

   $(".alert-success").remove();
   // if (window.location.href.indexOf('?') > -1) {
   //    window.location.href = window.location.pathname;
   //  }
}, 10000);
    // $(".alert-success").delay(20000).remove();
    
});
</script>