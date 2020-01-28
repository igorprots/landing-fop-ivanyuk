<!doctype html>
<html <?php language_attributes(); ?> >
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-156958515-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-156958515-1');
</script>


  <title><?php wp_title( '' ); ?><?php if ( wp_title( '', false ) ) { echo ' :'; } ?> <?php bloginfo( 'name' ); ?></title>

  <link href="//www.google-analytics.com/" rel="dns-prefetch">
  <link href="//fonts.googleapis.com" rel="dns-prefetch">
  <link href="//cdnjs.cloudflare.com" rel="dns-prefetch">

  <!-- icons -->
  <link href="<?php echo get_template_directory_uri(); ?>/favicon.ico" rel="shortcut icon">

  <!--[if lt IE 9]>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- css + javascript -->
  <link href="https://fonts.googleapis.com/css?family=Russo+One&display=swap" rel="stylesheet">
  <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header role="banner">
      <div class="container-fluid">
        <div class="row header">
            <div class="navbar col-12">
                <div class="navbar-header">
                    <button class="navbar-toggle collapsed" data-target=".navbar-collapse" data-toggle="collapse" type="button"><span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span> <span class="icon-bar"></span> <span
                            class="icon-bar"></span></button>
                    <a class="navbar-brand" aria-label="navbar" href="<?php echo home_url(); ?>">ФОП Іванюк О.С.</a>
                </div>

                <div class="collapse navbar-collapse">
                <?php /* wpeHeadNav(); */ ?>
                    <ul class="nav navbar-nav" role="navigation">
                        <li>
                            <a href="#service" aria-label="service">Послуги</a>
                        </li>

                        <li>
                            <a href="#portfolio" aria-label="portfolio">Портфоліо</a>
                        </li>

                        <li>
                            <a href="#petition" aria-label="petition">Залишити заявку</a>
                        </li>

                        <li>
                            <a href="#contacts" aria-label="contacts">Контакти</a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav social">
                        <li>
                            <a href="#map" aria-label="google map"><i class=" map-marker"></i>21023,
                                м.Вiнниця вул.Д.Галицького,27а <br>5 пов.каб.504</a>
                        </li>
                        <li>
                            <a href="mailto:fop.ivaniuk.oleksii@gmail.com" aria-label="email"><i
                                    class="envelope"></i>fop.ivaniuk.oleksii@gmail.com</a>
                        </li>
                        <li>
                            <a href="tel:+380683535630" aria-label="phone"><i class="phone"></i>тел.(068)-353-56-30</a>
                        </li>
                    </ul>
                </div>
      </div>
    </header>
