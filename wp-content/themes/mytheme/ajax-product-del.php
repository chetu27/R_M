<?php 
/*
   Template Name: Ajax Product Delete
   */ 

require_once(dirname( __FILE__ ).'/../../../wp-config.php');
$conn = new mysqli($servername, $username, $password, $dbname);
$date = date("Y-m-d H:i:s");
if(isset($_POST["id"]))
{
 $query = "UPDATE wp_product SET delete_at='$date' WHERE id = '".$_POST["id"]."'";
 if(mysqli_query($conn, $query))
 {
  echo 'Data Deleted';
 }
}

     // wp_redirect( home_url('product-listing?msg=1'));

?>