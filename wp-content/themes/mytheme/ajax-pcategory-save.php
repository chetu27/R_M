<?php 
/*
   Template Name: Ajax Product Category Save
   */ 

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$date = date("Y-m-d H:i:s");
if(isset($_POST["save"]))
{
	$name=$_POST['name'];
	 $sql = "INSERT INTO wp_product_cat (cat_name) VALUES ('$cat_name')";
          	if (mysqli_query($conn, $sql)) {
				echo json_encode(array("statusCode"=>200));
			} 
			else {
				echo json_encode(array("statusCode"=>201));
			}
			mysqli_close($conn); 

 }



?>