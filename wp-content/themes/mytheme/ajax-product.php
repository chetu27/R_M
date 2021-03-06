<?php 
/*
   Template Name: Ajax for Product
   */ 

require_once(dirname( __FILE__ ).'/../../../wp-config.php');
$conn = new mysqli($servername, $username, $password, $dbname);

extract($_POST);
$user_id=$conn->real_escape_string($id);
$status=$conn->real_escape_string($status);
$sql=$conn->query("UPDATE wp_product SET status='$status' WHERE id='$id'");
?>