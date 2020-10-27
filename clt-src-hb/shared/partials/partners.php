<?php 
    $_partners_slide_data = json_decode($user->get_ptn_inf_all(), true)['data'];
    // $util->Show($_partners_slide_data);
?>
<section class=" client_logos">
    <img src="shared/img/partner_mob.svg" class="partners_img mobile_view" style="margin-left: -6px;">
    <div class="container">
         <div class="row">
      
             <div class="col-md-12">
                 <img src="shared/img/partners.svg" class="partners_img desktop_view">
             
               

          </div>   
          
      </div>
    </div>
              
      <div class="container">
       <div class="brands row">
                <div class="col">
                 <div class="brands_slider_container">
                     <div class="owl-carousel owl-theme brands_slider">
                         <?php 
                            foreach( $_partners_slide_data as $_partners_slide ):
                                $_is_Active = json_decode($user->get_is_active($_partners_slide['userid']))->is_active->is_active;
                                if($_is_Active){
                                    $_ptn_pic = json_decode($picture->get_byitem_one_type('00', $_partners_slide['internal_id'], 3))->data;
                                    // $util->Show($_ptn_pic);
                                    $_ptn_lg_path = $util->AppUploads().'profiles/'.$_partners_slide['picture'];
                                    if($_ptn_pic->path_name){
                                        $_ptn_lg_path = $_ptn_pic->path_name;
                                    }
                         ?>
                                <div class="owl-item">
                                    <div class="brands_item d-flex flex-column justify-content-center"><img src="<?=$_ptn_lg_path?>" alt="<?=$_partners_slide['business_name']?>"></div>
                                </div>
                         <?php 
                                }
                            endforeach;
                         ?>
                          <!-- <div class="owl-item">
                             <div class="brands_item d-flex flex-column justify-content-center"><img src="shared/img/client.jpg" alt=""></div>
                         </div>
                          <div class="owl-item">
                             <div class="brands_item d-flex flex-column justify-content-center"><img src="shared/img/client.jpg" alt=""></div>
                         </div>
                          <div class="owl-item">
                             <div class="brands_item d-flex flex-column justify-content-center"><img src="shared/img/client.jpg" alt=""></div>
                         </div>
                          <div class="owl-item">
                             <div class="brands_item d-flex flex-column justify-content-center"><img src="shared/img/client.jpg" alt=""></div>
                         </div> <div class="owl-item">
                             <div class="brands_item d-flex flex-column justify-content-center"><img src="shared/img/client.jpg" alt=""></div>
                         </div> <div class="owl-item">
                             <div class="brands_item d-flex flex-column justify-content-center"><img src="shared/img/client.jpg" alt=""></div>
                         </div> <div class="owl-item">
                             <div class="brands_item d-flex flex-column justify-content-center"><img src="shared/img/client.jpg" alt=""></div>
                         </div> <div class="owl-item">
                             <div class="brands_item d-flex flex-column justify-content-center"><img src="shared/img/client.jpg" alt=""></div>
                         </div>
                          <div class="owl-item">
                             <div class="brands_item d-flex flex-column justify-content-center"><img src="shared/img/client.jpg" alt=""></div>
                         </div> <div class="owl-item">
                             <div class="brands_item d-flex flex-column justify-content-center"><img src="shared/img/client.jpg" alt=""></div>
                         </div> -->
                     </div> <!-- Brands Slider Navigation -->

                     <div class="brands_nav brands_prev"><i class="fas fa-chevron-left"></i></div>
                     <div class="brands_nav brands_next"><i class="fas fa-chevron-right"></i></div>
                 </div>
             </div>
 </div> 
          </div>
       
    </section>