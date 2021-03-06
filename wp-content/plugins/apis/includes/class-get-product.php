<?php

/*
Fetch All Data
*/ 
function productAvailable(){
	header('Content-Type:application/json');
	header('Acess-Control-Allow-Origin:*');	

	global $wpdb;
	$checkProduct = $_GET['checkPro'];
	$rows = $wpdb->get_results("SELECT * FROM wp_product WHERE product_name='$checkProduct'");
	//echo "<pre>"; print_r($rows); die;
	if(count($rows) > 0){
		echo json_encode($rows);
	}else{
		//echo json_encode(array('message' => 'No Record Found.','status' => false));
		return 0;
	}	
}

/*
Product Search By Barcode
*/ 

function productByBarcode(){
	header('Content-Type:application/json');
	header('Acess-Control-Allow-Origin:*');	

	global $wpdb;
	$barcode = $_GET['code'];
	$rows = $wpdb->get_results("SELECT product_name FROM wp_product WHERE barcode='$barcode'");
	if(count($rows) > 0){
		echo json_encode($rows);
	}else{
		//echo json_encode(array('message' => 'No Record Found.','status' => false));
		return 0;
	}
	
}



/*
Search Data AutoComplite
*/ 
function searchAutoComplete(){
	header('Content-Type:application/json');
	header('Acess-Control-Allow-Origin:*');	

	global $wpdb;
	$proName = $_GET['pro_name'];
	//print_r($proName);die();
	$rows = $wpdb->get_results("select * from wp_product WHERE product_name LIKE '%" .$proName. "%'");
	
	if($rows > 0){
		echo json_encode($rows);
	}else{
		echo json_encode(array('message' => 'No Record Found.','status' => false));
	}

}



/*
Fetch All Data by ID
*/

function getProductById(){
	header('Content-Type:application/json');
	header('Acess-Control-Allow-Origin:*');	
	//$data = json_decode(file_get_contents('php://input'), true);
	global $wpdb;
	$string = $_GET['pid'];
	$str = str_replace('\\', '', $string);
	$str1 = str_replace('"', '', $str);
	$explode_arr = (explode(',', $str1));
	$count = count($explode_arr);
	$arr=[];
	$master_array = [];
	foreach ($explode_arr as $key => $value) {
		$result = $wpdb->get_results("select * from wp_product where id = '$value'",'ARRAY_A');
		$master_array['product_list'][] = $result[0];
	}
	$match_recipie = $wpdb->get_results("SELECT wpr.product_id,wpr.recipe_id,wr.id,wr.recipe_name,wr.recipe_description, COUNT(recipe_id) as wp_r FROM wp_product_recipe as wpr JOIN wp_recipe as wr on wpr.recipe_id = wr.id WHERE product_id IN ($str1) GROUP BY recipe_id HAVING wp_r = '$count'",'ARRAY_A');
	for($i=0;$i<count($match_recipie);$i++){
		$recipie_id = $match_recipie[$i]['recipe_id'];

		$match_recipie[$i]['product'] = $wpdb->get_results("SELECT wp.product_name from wp_product_recipe as wpr JOIN wp_product as wp on wpr.product_id = wp.id where recipe_id = '$recipie_id'",'ARRAY_A');
		unset($match_recipie[$i]['wp_r']);
		$master_array['matched_recipie'][] = $match_recipie[$i];
	}
	echo json_encode($master_array);
	die();





	$product_lists['recipie_id'] = $wpdb->get_results("SELECT wpr.product_id,wpr.recipe_id,wr.id,wr.recipe_name,wr.recipe_description, COUNT(recipe_id) as wp_r FROM wp_product_recipe as wpr JOIN wp_recipe as wr on wpr.recipe_id = wr.id WHERE product_id IN ($str1) GROUP BY recipe_id HAVING wp_r = '$count'",'ARRAY_A');
	// echo $wpdb->last_query;
	
	foreach ($product_lists['recipie_id'] as $key => $value) {
		$recipeId = $value['id'];
		// print_r($recipeId);
		$product_lists[] = $wpdb->get_results("SELECT wpr.product_id,wpr.recipe_id,wp.id,wp.product_name from wp_product_recipe as wpr JOIN wp_product as wp on wpr.product_id = wp.id where recipe_id = '$recipeId'",'ARRAY_A'); 
		// echo $wpdb->last_query;
	}
	
	print_r($product_lists);
	die();

	 $finalResult = implode(",", $arr); 
	 $count = count($arr);
	$product_lists = $wpdb->get_results("select * from wp_product where product_name IN ($finalResult)",'ARRAY_A');
	$product_lists = GetRecipieDetails($product_lists);
	if($product_lists > 0){
	echo json_encode($product_lists);
	}else{
		echo json_encode(array('message' => 'No Record Found.','status' => false));
	}
		
}

function GetRecipieDetails($product_lists){
	global $wpdb;
	if(count($product_lists) > 1){
		for( $i=0; $i<count($product_lists); $i++){
			$recipie_id[] = $product_lists[$i]['id'];
		}
		// echo $count = count($recipie_id);
		// die();
		$where ='';
		foreach($recipie_id as $key => $val) {
		  if($key==0){
		  	$where .=" FIND_IN_SET('".$val."', product_list) ";
		  }else{
		  	$where .="  && FIND_IN_SET('".$val."', product_list) ";
		  }
		}
		$sqlquery =  "SELECT * FROM wp_recipe where". $where;
		// $recipie = $wpdb->get_results("select * from wp_recipe where CONCAT(',', product_list, ',') REGEXP ',($recipie_id),'",'ARRAY_A') ;
		$recipie = $wpdb->get_results("$sqlquery",'ARRAY_A');
			for( $i=0; $i<count($product_lists); $i++){
			$product_lists[$i]['recipie_details'] = $recipie;
			for( $j=0; $j<count($product_lists[$i]['recipie_details']); $j++){
			$prod_id = $product_lists[$i]['recipie_details'][$j]['product_list'];
			$product_lists[$i]['recipie_details'][$j]['product_list'] = $wpdb->get_results("select * from `wp_product` where id IN ($prod_id)","ARRAY_A");
			}
		}
	}else{
		for( $i=0; $i<count($product_lists); $i++){
		$recipie = $product_lists[$i]['id'];
		$product_lists[$i]['recipie_details'] = $wpdb->get_results("select * from wp_recipe where CONCAT(',', product_list, ',') REGEXP ',($recipie),'",'ARRAY_A');
		for( $j=0; $j<count($product_lists[$i]['recipie_details']); $j++){
		$prod_id = $product_lists[$i]['recipie_details'][$j]['product_list'];
		$product_lists[$i]['recipie_details'][$j]['product_list'] = $wpdb->get_results("select * from `wp_product` where id IN ($prod_id)","ARRAY_A");
		}
		}
	}

	return array_unique($product_lists);
}




function productInsert(){
	header('Content-Type:application/json');
	header('Access-Control-Allow-Origin:*');	
	header('Access-Control-Allow-Methods: POST');
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	// header("Access-Control-Allow-Headers: access");
	// header("Content-Type: application/json; charset=UTF-8");
	$data = json_decode(file_get_contents('php://input'), true);

	$barcode = $data['product_barcode'];
	$pname = $data['product_name'];
	$pro_cat = $data['product_cat'];
	$pro_des = $data['product_description'];
	$pro_recipe = $data['product_recipe'];
	$pro_nut = $data['product_nutrition'];
	$pro_ingr = $data['product_ingredients'];
	$pro_status = $data['product_status'];

	global $wpdb;
	$findProductName = $wpdb->get_results("select product_name from wp_product where product_name = '$pname'");
	//print_r($findProductName); die();
	//var_dump($wpdb->last_query);die;


	//global $wpdb;
	if(empty($barcode)){
		echo json_encode(array('message' => 'Barcode is Mandatory','status' => false));
	}elseif(empty($pname)){
		echo json_encode(array('message' => 'Product Name is Mandatory','status' => false));
	}elseif(!is_numeric($pro_cat)){
		echo json_encode(array('message' => 'Product Category Must be Numeric','status' => false));
	}elseif(count($findProductName) > 0){
		echo json_encode(array('message' => 'Product already Exist in your database','status' => false));
	}else{
		$rows = $wpdb->insert( 
		'wp_product', 
		array( 
			'barcode' 				=> $barcode,
			'product_name' 			=> $pname,
			'pro_cat' 				=> $pro_cat,
			'product_description' 	=> $pro_des,
			'recipe' 				=> $pro_recipe,
			'nutrition' 			=> $pro_nut,
			'ingredients' 			=> $pro_ingr,
			'status' 				=> $pro_status

		));
		if($rows){
			echo json_encode(array('message' => 'Product Insert Suceesfuly','status' => true));
		}else{
			echo json_encode(array('message' => 'Product Not Insert.','status' => false));
		}

	}
	//var_dump($wpdb->last_query);die;
	//print_r($rows);
}

function productUpdate(){

}

// $string = $_GET['pid'];
// 	global $wpdb;
// 	$rows = $wpdb->get_results("select * from wp_product where barcode IN ($string)");
// 	//$rows = $wpdb->get_results("select * from wp_product where barcode= {$str_arr}");
// 	if($rows > 0){
// 		echo json_encode($rows);
// 	}else{
// 		echo json_encode(array('message' => 'No Record Found.','status' => false));
// 	}
//=======
// global $wpdb;
// 	$string = $_GET['pid'];
// 	$pResult = $wpdb->get_results("select * from wp_product where barcode IN ($string)");
// 	foreach ($pResult as $value) {
// 		$recipen = $value->recipe;
// 		$rows = $wpdb->get_results("select * from wp_recipe where id IN ($recipen)");
// 		$rows1 = $wpdb->get_results("select * from wp_product");
// 		$res = json_encode($rows);
// 		$pro = json_encode($rows1);

// 		$array[] = json_decode($res, true);
// 		$array[] = json_decode($pro, true);

// 		if($rows > 0){
// 			echo json_encode($rows);
// 			}else{
// 				echo json_encode(array('message' => 'No Record Found.','status' => false));
// 		}

// 	}
// ==================
	// global $wpdb;
	// $string = $_GET['pid'];
	// $finaldata = [];
	// $recipie_data = [];
	// $product_lists = $wpdb->get_results("select * from wp_product where barcode IN ($string)",'ARRAY_A');
	// for( $i=0; $i<count($product_lists); $i++){
	// 	$recipie = $product_lists[$i]['recipe'];
	// 	$product_lists[$i]['recipie_details'][] = $wpdb->get_results("select * from wp_recipe where id IN ($recipie)");
		
	// }
	//print_r($product_lists);
