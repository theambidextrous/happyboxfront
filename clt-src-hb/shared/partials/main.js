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
autoplay:true,
autoplayTimeout:3000,
nav:false,
dots:false,
autoWidth:false,
   centerMode: true,
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

function currencyNumberFormat(amount) {
	var delimiter = ","; // replace comma if desired
	var a = amount.split('.',2)
	var d = a[1];
	var i = parseInt(a[0]);
	if(isNaN(i)) { return ''; }
	var minus = '';
	if(i < 0) { minus = '-'; }
	i = Math.abs(i);
	var n = new String(i);
	var a = [];
	while(n.length > 3) {
		var nn = n.substr(n.length-3);
		a.unshift(nn);
		n = n.substr(0,n.length-3);
	}
	if(n.length > 0) { a.unshift(n); }
	n = a.join(delimiter);
	if(d.length < 1) { amount = n; }
	else { amount = n + '.' + d; }
	amount = minus + amount;
	return amount;
}