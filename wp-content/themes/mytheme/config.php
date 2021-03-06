<?php
//require_once(dirname( __FILE__ ).'/../../../wp-config.php');
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if(!$conn)
{
    die (' Please Your Connectino '.mysqli_error());
}

if (!is_user_logged_in()) {  wp_redirect( home_url('login') ); }

$date = date("Y-m-d H:i:s");

$getuserid =  get_current_user_id();