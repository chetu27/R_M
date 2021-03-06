<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <title>{{ config('app.name', 'Recipe Me') }}</title> -->
     <title>Recipe Me</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/my_style.css') }}">

</head>
<body>

<div class="container" id=formPage>

<form action ="{{url('/')}}" method="GET">
   <div class="panel panel-default">
      <div class="panel-heading text-center">Recipe Me</div>
      <div class="panel-wrapper">
         <div class="panel-body d-flex">
            <div class="input-group control-group after-add-more">
               <input type="text" name="baarCodeNumber[]" id="baarCodeNumber" class="form-control proList" placeholder="Enter Product Name" autocomplete="off" />
               <div id="productList">
               </div>
               {{ csrf_field() }}
               <div class="input-group-btn"> 
                  <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add </button>
               </div>
            </div>
            <div class="barcode text-center"><button type="button" class="btn btn-primary text-light" id="scanbarbutton" type="button" data-toggle="modal" data-target="#livestream_scanner"><i class="fa fa-barcode" aria-hidden="true"></i> Scan Code</button></div>
            {{--  --}}            

            <div class="modal" id="livestream_scanner">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Barcode Scanner</h4>
                     </div>
                     <div class="modal-body" style="position: static">
                        <div id="interactive" class="viewport"></div>
                        <div class="error"></div>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                     </div>
                  </div>
               </div>
            </div>
            {{--  --}}
         </div>
         <div class="tags"></div>
      </div>
      <button type="SubmitButton" id="SubmitButton" class="btn btn-primary btn-lg">Search Recipe</button>
   </div>
</form>



@if(isset($responseBody) && count($responseBody) > 0)
@foreach($responseBody as $user)
  @foreach($user->recipie_details as $key1=>$res)
          <button class="accordion">{{$res->recipe_name}}</button>
          <div class="Accpanel">
              @foreach($res->product_list as $key => $val)
              <div class="control-group generated input-group proname">{{$val->product_name}}</div>
              @endforeach 
              <br>           
              <h4>Recipe Details:</h4>
              <p>{{$res->recipe_description}}</p>
          </div>
  @endforeach
@endforeach
@endif


@if(isset($responseBodym) && count($responseBodym) > 0)
@foreach($responseBodym as $detaisRecipe)    
    @foreach($detaisRecipe['recipie_details'] as $key1=>$res)   
            <button class="accordion">{{$res['recipe_name']}}</button>
            <div class="Accpanel">
                @foreach($res['product_list'] as $key => $val)
                <div class="control-group generated input-group proname">{{$val['product_name']}}</div>
                @endforeach 
                <br>           
                <h4>Recipe Details:</h4>
                <p>{{$res['recipe_description']}}</p>
            </div>
    @endforeach
@endforeach
@endif

 {{-- {{dd(isset($responseBodym))}} --}}


</div>
<script src="http://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://a.kabachnik.info/assets/js/libs/quagga.min.js"></script>
<script src="{{ asset('public/js/my_js.js') }}"></script>
<script type="text/javascript">
 $(document).ready(function() {


$(".add-more").click(function(e) {
    var findProductName = $("#baarCodeNumber").val();
    e.preventDefault();
    $.ajax({
      type: "GET",
      url: "{{ route('product-valid') }}",
      data: {
        findProductName: findProductName
      },
      success: function(result) {
        console.log(result[0].product_name);
        let productName = result[0].product_name

        if(productName !=undefined){
          var html = '<div class="control-group generated input-group proname" data_info="';
          // let val = $(event.target).parents().siblings("input").val();
          let val = productName;
          html += val+'" name="baarCodeNumber" style="margin-top:10px" >'+val;
          html +='<i class="fa fa-times remove" aria-hidden="true"></i><input type="hidden" name="baarCodeNumber[]" value="'+val+'" ></div>';
          $(".tags").append(html);
          $('.proList').val("");
        }else{
          alert('Product not exists in product list.')
          $('.proList').val("");
        }
        
      },
      error: function(result) {
        alert('error');
      }
    });
  });

/*
Dynamic Tag Add
*/ 
// $(".add-more").click(function(e){
//     if($(event.target).parents().siblings("input").val() ==''){
//        $('.proList').val("");
//   }else{
//     var html = '<div class="control-group generated input-group proname" data_info="';
//     let val = $(event.target).parents().siblings("input").val();
//     html += val+'" name="baarCodeNumber" style="margin-top:10px" >'+val;
//     html +='<i class="fa fa-times remove" aria-hidden="true"></i><input type="hidden" name="baarCodeNumber[]" value="'+val+'" ></div>';


//     $(".tags").append(html);
//     $('.proList').val("");
//   }
//   });


  $("body").on("click",".remove",function(){ 
     $(this).parents(".control-group").remove();
    });

/* 
Auto Complete Search
*/ 
  $('#baarCodeNumber').keyup(function(){ 
        var query = $(this).val();
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('search-product') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
           $('#productList').fadeIn();  
              $('#productList').html(data);
          }
         });
        }
    });

    $(document).on('click', 'li', function(){  
        $('#baarCodeNumber').val($(this).text());  
        $('#productList').fadeOut();  
    });
 
});
 
</script>

</body>
</html>
