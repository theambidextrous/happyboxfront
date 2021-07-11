<link rel="stylesheet" href="<?=$util->AppHome()?>/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?=$util->AppHome()?>/vendor/fa5/css/all.min.css">
<link rel="stylesheet" href="<?=$util->AppHome()?>/vendor/owl/owl.carousel.min.css">
<link rel="stylesheet" href="<?=$util->AppHome()?>/vendor/owl/owl.theme.default.css">
<link href="https://db.onlinewebfonts.com/c/a78cfad3beb089a6ce86d4e280fa270b?family=Calibri" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="<?=$util->AppHome()?>/vendor/custom/custom-css.css?version=2.0" >
<style>
.stars
{
  margin: 20px 0;
  font-size: 24px;
  color: #d17581;
}
.rating {
      float:left;
    }

    /* :not(:checked) is a filter, so that browsers that don’t support :checked don’t 
      follow these rules. Every browser that supports :checked also supports :not(), so
      it doesn’t make the test unnecessarily selective */
    .rating:not(:checked) > input {
        position:absolute;
        top:-9999px;
        clip:rect(0,0,0,0);
    }

    .rating:not(:checked) > label {
        float:right;
        width:1em;
        /* padding:0 .1em; */
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:300%;
        line-height:1.2;
        color:#ddd;
    }

    .rating:not(:checked) > label:before {
        content: '★ ';
    }

    .rating > input:checked ~ label {
        color: dodgerblue;
        
    }

    .rating:not(:checked) > label:hover,
    .rating:not(:checked) > label:hover ~ label {
        color: dodgerblue;
        
    }
    .ptn-label{
      color: #0babb3!important;
      font-weight: 100!important;
    }
    .rating label:hover, .rating label:hover ~ label, .rating input:checked + label, .rating input:checked + label ~ label 
    {
      color: #1c90ff!important;
    }

    .rating > input:checked + label:hover,
    .rating > input:checked + label:hover ~ label,
    .rating > input:checked ~ label:hover,
    .rating > input:checked ~ label:hover ~ label,
    .rating > label:hover ~ input:checked ~ label {
        color: dodgerblue;
        
    }

    .rating > label:active {
        position:relative;
        top:2px;
        left:2px;
    }
</style>
<!-- google analytics-->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-BCJNEQRLGH"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-BCJNEQRLGH');
</script>
<!-- end google analytics-->