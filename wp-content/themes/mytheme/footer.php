<?php wp_footer(); ?>
</div>
<div class="footer">
  Copyright © <?php echo date("Y"); ?> FBAG. All rights reserved.
</div>
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://a.kabachnik.info/assets/js/libs/quagga.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>

<script type="text/javascript">
   $('select').selectpicker();
</script>

<script type="text/javascript">
    $(document).ready(function(){
    $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
    });
});



  $(document).ready(function() {
    $('#recipe_list').DataTable({
    });
  });
  $(document).ready(function() {
    $('#productc_list').DataTable({
    });
  });

 $(document).ready(function() {
    $('#product_list').DataTable({
      columnDefs: [
          {  
            bSortable: false,
            aTargets: [ -1, -7 ]
          }
      ]      
    });
} );

</script>

<script type="text/javascript">
$(document).on('click','.status_checks_pro',function(){
      //var name = 'mohit';
      var status = ($(this).hasClass("btn-success")) ? '0' : '1';
      var msg = (status=='0')? 'Deactivate' : 'Activate';
      if(confirm("Are you sure to "+ msg)){
        var current_element = $(this);
        url = "<?php echo home_url('ajax-product'); ?>";
        $.ajax({
          type:"POST",
          url: url,
          data: {id:$(current_element).attr('data'),status:status},
          success: function(data)
          {  
            location.reload();
          }
        });
      }      
    });
</script>


<script type="text/javascript">
$(document).on('click','.status_checks',function(){
      var status = ($(this).hasClass("btn-success")) ? '0' : '1';
      var msg = (status=='0')? 'Deactivate' : 'Activate';
      if(confirm("Are you sure to "+ msg)){
        var current_element = $(this);
        //alert(JSON.stringify(current_element));
        // url = "<?php //echo get_template_directory_uri(); ?>/ajax.php";
        url = "<?php echo home_url('ajax-recipe'); ?>";
        $.ajax({
          type:"POST",
          url: url,
          data: {id:$(current_element).attr('data'),status:status},
          success: function(data)
          {
          //alert(data);   
            location.reload();
          }
        });
      }      
    });
</script>
<style>
      #interactive.viewport {position: relative; width: 100%; height: auto; overflow: hidden; text-align: center;}
      #interactive.viewport > canvas, #interactive.viewport > video {max-width: 100%;width: 100%;}
      canvas.drawing, canvas.drawingBuffer {position: absolute; left: 0; top: 0;}
    </style>
    <script type="text/javascript">
    $(function() {
      // Create the QuaggaJS config object for the live stream
      var liveStreamConfig = {
          inputStream: {
            type : "LiveStream",
            constraints: {
              width: {min: 640},
              height: {min: 480},
              aspectRatio: {min: 1, max: 100},
              facingMode: "environment" // or "user" for the front camera
            }
          },
          locator: {
            patchSize: "medium",
            halfSample: true
          },
          numOfWorkers: (navigator.hardwareConcurrency ? navigator.hardwareConcurrency : 4),
          decoder: {
            "readers":[
              {"format":"ean_reader","config":{}}
            ]
          },
          locate: true
        };
      // The fallback to the file API requires a different inputStream option. 
      // The rest is the same 
      var fileConfig = $.extend(
          {}, 
          liveStreamConfig,
          {
            inputStream: {
              size: 800
            }
          }
        );
      // Start the live stream scanner when the modal opens
      $('#livestream_scanner').on('shown.bs.modal', function (e) {
        Quagga.init(
          liveStreamConfig, 
          function(err) {
            if (err) {
              $('#livestream_scanner .modal-body .error').html('<div class="alert alert-danger"><strong><i class="fa fa-exclamation-triangle"></i> '+err.name+'</strong>: '+err.message+'</div>');
              Quagga.stop();
              return;
            }
            Quagga.start();
          }
        );
        });
      
      // Make sure, QuaggaJS draws frames an lines around possible 
      // barcodes on the live stream
      Quagga.onProcessed(function(result) {
        var drawingCtx = Quagga.canvas.ctx.overlay,
          drawingCanvas = Quagga.canvas.dom.overlay;
     
        if (result) {
          if (result.boxes) {
            drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
            result.boxes.filter(function (box) {
              return box !== result.box;
            }).forEach(function (box) {
              Quagga.ImageDebug.drawPath(box, {x: 0, y: 1}, drawingCtx, {color: "green", lineWidth: 2});
            });
          }
     
          if (result.box) {
            Quagga.ImageDebug.drawPath(result.box, {x: 0, y: 1}, drawingCtx, {color: "#00F", lineWidth: 2});
          }
     
          if (result.codeResult && result.codeResult.code) {
            Quagga.ImageDebug.drawPath(result.line, {x: 'x', y: 'y'}, drawingCtx, {color: 'red', lineWidth: 3});
          }
        }
      });
      
      // Once a barcode had been read successfully, stop quagga and 
      // close the modal after a second to let the user notice where 
      // the barcode had actually been found.
      Quagga.onDetected(function(result) {        
        if (result.codeResult.code){
          $('#scanner_input').val(result.codeResult.code);
          Quagga.stop();  
          setTimeout(function(){ $('#livestream_scanner').modal('hide'); }, 1000);      
        }
      });
        
      // Stop quagga in any case, when the modal is closed
        $('#livestream_scanner').on('hide.bs.modal', function(){
          if (Quagga){
            Quagga.stop();  
          }
        });
      
      // Call Quagga.decodeSingle() for every file selected in the 
      // file input
      $("#livestream_scanner input:file").on("change", function(e) {
        if (e.target.files && e.target.files.length) {
          Quagga.decodeSingle($.extend({}, fileConfig, {src: URL.createObjectURL(e.target.files[0])}), function(result) {alert(result.codeResult.code);});
        }
      });
    });
    </script>
    <script type="text/javascript">


/*
Click all chekbox.
*/
$(document).ready(function () {
    $("#selectAll").click(function () {
        $(".checkbox1").prop('checked', $(this).prop('checked'));
    });
});

/*
Disable Delete Button until we cheked checkbox.
*/
$('#selectAll').click(function () {   
  let test = !$('.checkbox1').not(':checked').length;
  if (test == false){
    $('#delete').removeAttr('disabled');
    $('#active').removeAttr('disabled');
    $('#rinactive').removeAttr('disabled');
    $('#inactivate').removeAttr('disabled');
  }else{
    $('#delete').attr('disabled', true);
    $('#active').attr('disabled', true);
    $('#rinactive').attr('disabled', true);
    $('#inactivate').attr('disabled', true);
  }
});
/*
Disable Delete Button until we atleast one cheked checkbox.
*/
$('.checkbox1').click(function () {
  $('#delete').prop('disabled',$('input.checkbox1:checked').length == 0); 
  $('#active').prop('disabled',$('input.checkbox1:checked').length == 0);
  $('#rinactive').attr('disabled',$('input.checkbox1:checked').length == 0);
  $('#inactivate').prop('disabled',$('input.checkbox1:checked').length == 0); 
});                                

    </script>
</body>
</html>
