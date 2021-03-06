<section class="section faq-page">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div id="accordion">
            <div class="card">
              <div class="card-header"> <a class="card-link" data-toggle="collapse" href="#collapseOne"> What is Yoga and what kind of Yoga does Yog Mantrana teach & Practice? </a> </div>
              <div id="collapseOne" class="collapse show" data-parent="#accordion">
                <div class="card-body">
                   <p> Yoga is not only about asanas, It’s much beyond. It is an ancient art & science of overall wellbeing. Yoga is derived from the Sanskrit word “Yuj” means “Union”, ie union of mind Body &amp; Soul. So, it’s a soulful journey to peace, happiness, health & prosperity of your life. Yog Mantrana teaches typical Indian traditional Yoga – Satyananda Style. </p>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header"> <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">  What are the qualities & qualifications required to become Yoga Teacher?  </a> </div>
              <div id="collapseTwo" class="collapse" data-parent="#accordion">
                <div class="card-body"> <p> A high degree of self-motivation & sincere desire to learn and openness to the teachings of yoga. For Global Yoga Alliance Certification, you need to attend 200/500 hrs YTTC as part of certification course. </p> </div>
              </div>
            </div>                       
            <div class="card">
              <div class="card-header"> <a class="collapsed card-link" data-toggle="collapse" href="#collapseFive">   What is the validity & reliability of certificate issued by YogMantrana?  </a> </div>
              <div id="collapseFive" class="collapse" data-parent="#accordion">
                <div class="card-body"> <p>YogMantrana facilitates RYT certificate that is approved by Global Yoga Alliance & is valid in more than 300 countries. This certificate gives you the status of a registered Yoga & helps you setting up your own studio. </p> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  =======================================
  <section class="section faq-page">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div id="accordion">
             <?php $args = array('post_type' => 'faq','posts_per_page'=>-1,'post_status' => 'publish');
            $loop = new WP_Query( $args );
     $i='1'; while ( $loop->have_posts() ) : $loop->the_post();?>
      
            <div class="card">
              <div class="card-header"> <a class="<?php if($i=='1'){?> card-link <?php } else{ ?> collapsed card-link  <?php   }?>" data-toggle="collapse" href="#collapse_<?php echo $i;?>"><?php echo $post->post_title ?></a> </div>
              <div id="collapse_<?php echo $i;?>" class="collapse <?php if($i=='1'){?> show <?php } ?>" data-parent="#accordion">
                <div class="card-body">
                   <p> <?php echo $post->post_content ?> </p>
                </div>
              </div>
            </div>
            <?php $i++; endwhile; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
