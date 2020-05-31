  <script src="<?=$util->ClientHome()?>/vendor/jquery/jquery.min.js"></script>
  <script src="<?=$util->ClientHome()?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?=$util->ClientHome()?>/vendor/owl/owl.carousel.js"></script>
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
//back to top arrow
$('#goTop').on('click', function(e){
    $("html, body").animate({scrollTop: $("#top").offset().top}, 500);
});


});


</script>
      
     
