jQuery(document).ready(function(){
	jQuery("#submit").click(function(){
		var name = jQuery("#pro_category").val();
		if (name == ""){
	        alert("Please enter name");
	        $("#name").focus();
	    }else{
			jQuery.ajax({
			type: 'POST',
			url: MyAjax.ajaxurl,
			data: {"action": "insert_form", "pro_category":name},
				success: function(data){
				//alert(data);
					$("#success").show();
					$('#success').html('Data added successfully !');
					$("#insertdata")[0].reset();
				}
			});
		}
	});	
	jQuery("#Updatebutton").click(function(){
		var name = jQuery("#pro_category").val();
		if (name == ""){
	        alert("Please enter name");
	        $("#name").focus();
	    }else{
			jQuery.ajax({
			type: 'POST',
			url: MyAjax.ajaxurl,
			data: {"action": "update_form", "pro_category":name},
				success: function(data){
				//alert(data);
					$("#success").show();
					$('#success').html('Data Update successfully !');
					$("#insertdata")[0].reset();
				}
			});
		}
	});
});