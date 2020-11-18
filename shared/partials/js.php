    <script src="<?=$util->ClientHome()?>/vendor/jquery/jquery.min.js"></script>
   
    <script src="<?=$util->ClientHome()?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
         <script src="<?=$util->ClientHome()?>/vendor/bootstrap/js/popper.min.js"></script>
    <script src="<?=$util->ClientHome()?>/vendor/owl/owl.carousel.js"></script>
    <script src="<?=$util->ClientHome()?>/vendor/bootstrap/js/wt.js"></script>
      <!-- jQuery Tinymce -->
  <script src="<?=$util->AppHome()?>/adm-src-hb/vendor/tinymce/jquery.tinymce.min.js"></script>
  <script src="<?=$util->AppHome()?>/adm-src-hb/vendor/tinymce/tinymce.min.js"></script>
    <script>
      $(document).ready(function(){

if($('.brands_slider').length)
{
var brandsSlider = $('.brands_slider');

brandsSlider.owlCarousel(
{
loop:true,
autoplay:true,
autoplayTimeout:5000,
nav:false,
dots:false,
autoWidth:false,
margin:42,
responsiveClass:true,
    responsive:{
        0:{
            items:3,
            nav:true
        },
        600:{
            items:5,
            nav:false
        },
        1000:{
            items:7,
            nav:false,
            loop:false
        }
    }
});

if($('.brands_prev').length)
{
var prev = $('.brands_prev');
prev.on('click', function()
{
brandsSlider.trigger('prev.owl.carousel');
});
}

if($('.brands_next').length)
{
var next = $('.brands_next');
next.on('click', function()
{
brandsSlider.trigger('next.owl.carousel');
});
}
}
//mobile why slider

if($('.why_slider').length)
{
var whySlider = $('.why_slider');

whySlider.owlCarousel(
{
loop:true,
autoplay:true,
autoplayTimeout:3000,
nav:false,
dots:false,
autoWidth:false,
margin:42,
responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:false
        },
        600:{
            items:1,
            nav:false
        },
        1000:{
            items:7,
            nav:false,
            loop:false
        }
    }
});

if($('.why_prev').length)
{
var prev = $('.why_prev');
prev.on('click', function()
{
whySlider.trigger('prev.owl.carousel');
});
}

if($('.why_next').length)
{
var next = $('.why_next');
next.on('click', function()
{
whySlider.trigger('next.owl.carousel');
});
}
}
//back to top arrow
$('#goTop').on('click', function(e){
    $("html, body").animate({scrollTop: $("#top").offset().top}, 500);
});

//mob menu
 $('.menu-toggle').click(function() {

 // $('ul').toggleClass('opening');
 //$(this).toggleClass('open');
//$(".opened_menu").fadeIn();
 $(".opened_menu").fadeIn("slow");
$(".menu-close").show();
 
});

//close
$('.menu-close').click(function() {
 $(".opened_menu").fadeOut("slow");
  $(".hamburger").show();
 
 

});   
//Load TinyMCE	
       /* tinymce.init({		
          selector: 'textarea.tinymce',
          height: 150,
          theme: 'modern',
          menubar: false,	
          plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code help wordcount'
          ],
          toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link unlink | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat | help'
        });*/
        tinymce.init({
  selector: "textarea",
    setup: function (editor) {
        editor.on('change', function () {
            tinymce.triggerSave();
        });
    }
});


});


</script>
      
     
