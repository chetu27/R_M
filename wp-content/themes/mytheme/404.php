<?php get_header(); ?>
<div class="container">
<h1>Oops! That page can&rsquo;t be found.</h1>
<p>It looks like nothing was found at this location</p>
</div>
<script>
         setTimeout(function(){
            window.location.href = '<?php echo site_url('/'); ?>';
         }, 3000);
      </script>
 <script language="javascript" type="text/javascript">    
     window.location="<?php echo site_url('/'); ?>";
 </script>
<?php //get_sidebar( 'content-bottom' ); ?>
<?php //get_sidebar(); ?>
<?php get_footer(); ?>
