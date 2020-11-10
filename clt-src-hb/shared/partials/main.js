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




      //mobile hambuger menu
      

//back to top arrow
$('#goTop').on('click', function(e){
    $("html, body").animate({scrollTop: $("#top").offset().top}, 500);
});
   //hight current menu
 
  $('li.active').removeClass('active');
  $('a[href="' + location.pathname + '"]').closest('li').addClass('active'); 

  //WHY MOBILE SLIDER
    //mobile why slider

if($('.why_slider').length)
{
var whySlider = $('.why_slider');

whySlider.owlCarousel(
{
   
loop:true,
autoplay:false,
autoplayTimeout:3000,
nav:false,
dots:false,
autoWidth:false,
centerMode: true,
margin:42,
responsiveClass:true,
  stagePadding: 70,
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

//mobile hamburger
 //mobile hambuger menu
      
/*$('.menu-toggle').click(function() {

  $('ul').toggleClass('opening');
 $(this).toggleClass('open');
//$(".opened_menu").fadeIn();
})
*/
//close menu

                /*$('.menu-close').click(function() {

  $(".opened_menu").fadeOut();

})*/
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

}
);

//Format number to 2 decimal points with comma on thousand
function CurrencyFormatted(amount) {
	var i = parseFloat(amount);
	if(isNaN(i)) { i = 0.00; }
	var minus = '';
	if(i < 0) { minus = '-'; }
	i = Math.abs(i);
	i = parseInt((i + .005) * 100);
	i = i / 100;
	s = new String(i);
	if(s.indexOf('.') < 0) { s += '.00'; }
	if(s.indexOf('.') == (s.length - 2)) { s += '0'; }
	s = minus + s;
	return s;
}

function currencyNumberFormat(amount = CurrencyFormatted(amount)) {
	return parseFloat(amount).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
}