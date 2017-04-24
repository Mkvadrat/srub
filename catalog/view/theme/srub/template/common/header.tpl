<!DOCTYPE html>

<html lang="ru">
<!-- HelloPreload http://hello-site.ru/preloader/ -->
<style type="text/css">#hellopreloader>p{display:none;}#hellopreloader_preload{display: block;position: fixed;z-index: 99999;top: 0;left: 0;width: 100%;height: 100%;min-width: 1000px;background: #EB974E url(http://hello-site.ru//main/images/preloads/tail-spin.svg) center center no-repeat;background-size:62px;}</style>
<div id="hellopreloader"><div id="hellopreloader_preload"></div><p><a href="http://hello-site.ru">Hello-Site.ru. Бесплатный конструктор сайтов.</a></p></div>
<script type="text/javascript">var hellopreloader = document.getElementById("hellopreloader_preload");function fadeOutnojquery(el){el.style.opacity = 1;var interhellopreloader = setInterval(function(){el.style.opacity = el.style.opacity - 0.05;if (el.style.opacity <=0.05){ clearInterval(interhellopreloader);hellopreloader.style.display = "none";}},16);}window.onload = function(){setTimeout(function(){fadeOutnojquery(hellopreloader);},1000);};</script>
<!-- HelloPreload http://hello-site.ru/preloader/ -->

<head>

  <meta charset="utf-8">

  <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1"> -->

  <title><?php echo $title; if (isset($_GET['page'])) { echo " - ". ((int) $_GET['page'])." ".$text_page;} ?></title>

	<base href="<?php echo $base; ?>" />

    <meta name="viewport" content="width=1320">
        
    <meta name="format-detection" content="telephone=no">
    
    <?php if ($description) { ?>
    
    <meta name="description" content="<?php echo $description; if (isset($_GET['page'])) { echo " - ". ((int) $_GET['page'])." ".$text_page;} ?>" />
    
    <?php } ?>
    
    <?php if ($keywords) { ?>
    
    <meta name="keywords" content= "<?php echo $keywords; ?>" />
    
    <?php } ?>
    
    <meta property="og:title" content="<?php echo $title; if (isset($_GET['page'])) { echo " - ". ((int) $_GET['page'])." ".$text_page;} ?>" />
    
    <meta property="og:type" content="website" />
    
    <meta property="og:url" content="<?php echo $og_url; ?>" />
    
    <?php if ($og_image) { ?>
    
    <meta property="og:image" content="<?php echo $og_image; ?>" />
    
    <?php } else { ?>
    
    <meta property="og:image" content="<?php echo $logo; ?>" />
    
    <?php } ?>
    
    <meta property="og:site_name" content="<?php echo $name; ?>" />
    
    <!-- Bootstrap -->
    
    <!--<link href="css/bootstrap.css" rel="stylesheet">
    
    <script src="js/bootstrap.min.js"></script>-->
    
    
    
    <link rel="stylesheet" href="catalog/view/theme/srub/js/owl-carousel/owl.carousel.css">
    
    <link rel="stylesheet" href="catalog/view/theme/srub/js/owl-carousel/owl.theme.css">
    
    
    
    <link rel="stylesheet" href="catalog/view/theme/srub/css/reset.css">
    
    <link rel="stylesheet" href="catalog/view/theme/srub/css/fonts.css">
    
    <link rel="stylesheet" href="catalog/view/theme/srub/css/slider-pro.css">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    
    
    
    <link rel="stylesheet" href="catalog/view/theme/srub/css/3D-slider.css">
    
    <link rel="stylesheet" href="catalog/view/theme/srub/css/main.css">
    
    <link rel="stylesheet" href="catalog/view/theme/srub/css/in-page.css">
    
    <link rel="stylesheet" href="catalog/view/theme/srub/css/in-page-list.css">
    
    <link rel="stylesheet" href="catalog/view/theme/srub/css/price-in.css">
    
    <link rel="stylesheet" href="catalog/view/theme/srub/css/contacts.css">
    
    <link rel="stylesheet" href="catalog/view/theme/srub/css/projects.css">
    
    <link rel="stylesheet" href="catalog/view/theme/srub/css/about.css">
    
    <link rel="stylesheet" href="catalog/view/theme/srub/css/projects-in.css">
    
    <link rel="stylesheet" href="catalog/view/theme/srub/css/price.css">
    
    <link rel="stylesheet" href="catalog/view/theme/srub/css/404.css">
    
    <link rel="stylesheet" href="catalog/view/theme/srub/css/search.css">
    
    <script type="text/javascript" src="catalog/view/theme/srub/js/modernizr.custom.53451.js"></script>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
    <!--<script src="catalog/view/theme/srub/js/jquery-3.1.0.min.js"></script>-->
    
    <script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    
    <script type="text/javascript" src="catalog/view/theme/srub/js/jquery.gallery.js"></script>
    
    <script src="catalog/view/theme/srub/js/scripts.js"></script>
    
    
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    
    <!--[if lt IE 9]>
    
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    
    <![endif]-->
    
    
    
    <!-- OWL-CAROUSEL -->
    
    <script src="catalog/view/theme/srub/js/owl-carousel/owl.carousel.min.js"></script>
    
    
    
    <script src="catalog/view/theme/srub/js/jquery.sliderPro.js"></script>
    
    
    
    <!--SLICK CAROUSEL -->
    
    <script src="catalog/view/theme/srub/js/slick/slick.min.js"></script>
    
    <link rel="stylesheet" href="catalog/view/theme/srub/js/slick/slick.css">
    
    <link rel="stylesheet" href="catalog/view/theme/srub/js/slick/slick-theme.css">
    
    
    
    <!-- FANCYBOX -->
    
    <link rel="stylesheet" href="catalog/view/theme/srub/js/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
    
    <script type="text/javascript" src="catalog/view/theme/srub/js/source/jquery.fancybox.pack.js?v=2.1.5"></script>
    
    <link rel="stylesheet" href="catalog/view/theme/srub/srub/js/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
    
    <script type="text/javascript" src="catalog/view/theme/srub/js/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
    
    <script type="text/javascript" src="catalog/view/theme/srub/js/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
    
    <link rel="stylesheet" href="catalog/view/theme/srub/js/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
    
    <script type="text/javascript" src="catalog/view/theme/srub/js/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
    
    
    
    <!-- COLOR BOX -->
    
    <script src="catalog/view/theme/srub/js/colorbox/jquery.colorbox-min.js"></script>
    
    <script src="catalog/view/theme/srub/js/colorbox/jquery.colorbox.js"></script>
    
    <link rel="stylesheet" href="catalog/view/theme/srub/js/colorbox/colorbox.css">
    
    <!-- SWYPE -->
    
    <script src="catalog/view/theme/srub/js/jquery.touchSwipe.min.js"></script>
    
    <script src="catalog/view/theme/srub/js/jquery.touchSwipe.js"></script>
    
    
    
    
    
    <?php foreach ($styles as $style) { ?>
    
    <link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
    
    <?php } ?>
    
    <!--FAVICON-->
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    
    <?php foreach ($links as $link) { ?>
    
    <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" type="<?php echo $link['type']; ?>" />
    
    <?php } ?>
    
    <?php foreach ($scripts as $script) { ?>
    
    <script src="<?php echo $script; ?>" type="text/javascript"></script>
    
    <?php } ?>
    
    <?php foreach ($analytics as $analytic) { ?>
    
    <?php echo $analytic; ?>
    
    <?php } ?>

</head>

<body>

  <div class="wrapper">

    <!-- start header -->

    <header>

        <?php if ($logo) { ?>

        <?php if ($home == $og_url) { ?>

          <img class="logo" src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" />

        <?php } else { ?>

          <a class="logo" href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a>

        <?php } ?>

        <?php } else { ?>

          <h1><a class="logo" href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>

        <?php } ?>



      <div class="contacts-search">

        <p><?php echo $telephone; ?></p>

        <p><span>skype:</span> <?php echo $skype; ?></p>



        <div id="search_header" class="box-search">

          <input type="search" name="search" value="<?php echo $search; ?>" placeholder="Поиск">

          <input type="submit" value="">

        </div>

        <script>

        /* Search */

        $('#search_header input[name=\'search\']').parent().find('input[type=\'submit\']').on('click', function() {

          url = $('base').attr('href') + 'index.php?route=product/search';



          var value = $('header input[name=\'search\']').val();



          if (value) {

          url += '&search=' + encodeURIComponent(value);

          }



          location = url;

        });



        $('#search_header input[name=\'search\']').on('keydown', function(e) {

          if (e.keyCode == 13) {

          $('header input[name=\'search\']').parent().find('input[type=\'submit\']').trigger('click');

          }

        });

        </script>

      </div>



      <p class="text-in-header"><?php echo $slogan; ?></p>



      <ul class="socials">

        <li><a href="http://vk.com/srubkrym"><img src="catalog/view/theme/srub/images/vk.jpg" alt=""></a></li>

        <li><a href="https://www.facebook.com/srubkrym"><img src="catalog/view/theme/srub/images/fb.jpg" alt=""></a></li>

        <li><a href="https://twitter.com/srubkrym"><img src="catalog/view/theme/srub/images/tw.jpg" alt=""></a></li>

        <li><a href="http://www.ok.ru/srubkrym"><img src="catalog/view/theme/srub/images/odn.jpg" alt=""></a></li>

      </ul>



      <ul class="header-menu">

        <li><a href="<?php echo $about_company; ?>">О компании</a></li>

        <li><a href="<?php echo $operating_procedure; ?>">Порядок работы</a></li>

        <li><a href="<?php echo $important_to_know; ?>">Важно знать!</a></li>

        <!--<li><a href="<?php echo $gallery; ?>">Галерея работ</a></li>-->

        <li><a href="<?php echo $ads; ?>">Объявления</a></li>

        <li><a href="<?php echo $news; ?>">Новости компании</a></li>

        <!--<li><a href="<?php echo $our_price; ?>">Наши цены</a></li>-->

        <li><a href="<?php echo $contact; ?>">Контакты</a></li>

      </ul>

    </header>

    <!-- end header -->

  </div>

  <div class="top-slider">
  <div id="preloader"></div>

  <div class="lazy slider" data-sizes="50vw">

    <?php foreach ($banners as $banner) { ?>

    <?php if ($banner['link']) { ?>

    <div>

      <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>

    </div>

    <?php } else { ?>

    <div>

      <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />

    </div>

    <?php } ?>

    <?php } ?>

    </div>

  </div>

  <!-- end top slider -->

  <script>
  /*$(document).ready(function($) {
    $(window).load(function() {
      setTimeout(function() {
        $('#preloader').fadeOut('slow', function() {});
      }, 2000);
    });
  });*/
  </script>

  <!-- start dropdown menu -->

  <div class="dropdown-menu">

    <ul>

      <li class="fourth-punkt"><a href="<?php echo $home; ?>"><span>Вернуться на главную страницу</span></a></li>



      <li class="fourth-punkt"><a href="<?php echo $gallery; ?>"><span>Перейти в галерею</span></a></li>



      <?php if ($projects || $main_projects_name) { ?>

      <li class="dropdown first-punkt"><a href="<?php echo $main_projects_href; ?>"><span><?php echo $main_projects_name; ?></span></a>

        <ul>

        <?php foreach ($projects as $project) { ?>

          <li><a href="<?php echo $project['href']; ?>"><span><?php echo $project['name']; ?></span></a></li>

        <?php } ?>

        </ul>

      </li>

      <?php } ?>

      <?php if ($prices || $main_prices_name) { ?>

      <li class="dropdown first-punkt"><a href="<?php echo $main_prices_href; ?>"><span><?php echo $main_prices_name; ?></span></a>

        <ul>

        <?php foreach ($prices as $price) { ?>

          <li><a href="<?php echo $price['href']; ?>"><span><?php echo $price['name']; ?></span></a></li>

        <?php } ?>

        </ul>

      </li>

      <?php } ?>

      <!--<li class="fourth-punkt"><a href="<?php echo $our_price; ?>"><span>Наши цены</span></a></li>-->

      <li class="fourth-punkt"><a href="<?php echo $lumber; ?>"><span>Пиломатериалы</span></a></li>



      <?php if ($informations) { ?>

      <li class="dropdown sixth-punkt"><a class="disabled" href="#"><span>Статьи</span></a>

        <ul>

        <?php foreach ($informations as $information) { ?>

          <li><a href="<?php echo $information['href']; ?>"><span><?php echo $information['title']; ?></span></a></li>

        <?php } ?>

        </ul>

      </li>

      <?php } ?>

    </ul>

  </div>

  <!-- end dropdown menu -->
