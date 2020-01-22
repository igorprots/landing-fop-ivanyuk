<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

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
    <header>
      <div class="container-fluid">
        <div class="row header">
            <div class="navbar col-12">
                <div class="navbar-header">
                    <button class="navbar-toggle collapsed" data-target=".navbar-collapse" data-toggle="collapse" type="button"><span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span> <span class="icon-bar"></span> <span
                            class="icon-bar"></span></button>
                    <a class="navbar-brand" href="<?php echo home_url(); ?>">ФОП Іванюк О.С.</a>
                </div>

                <div class="collapse navbar-collapse">
                <?php /* wpeHeadNav(); */ ?>
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="#service">Послуги</a>
                        </li>

                        <li>
                            <a href="#portfolio">Портфоліо</a>
                        </li>

                        <li>
                            <a href="#petition">Залишити заявку</a>
                        </li>

                        <li>
                            <a href="#contacts">Контакти</a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav social">
                        <li>
                            <a href="#map"><i class="fa fa-map-marker"></i>21023,
                                м.Вiнниця <br>вул.Д.Галицького,27а <br>5
                                пов.каб.504</a>
                        </li>
                        <li>
                            <a href="mailto:fop.ivaniuk.oleksii@gmail.com"><i
                                    class="fa fa-envelope"></i>fop.ivaniuk.oleksii@gmail.com</a>
                        </li>
                        <li>
                            <a href="tel:+380683535630"><i class="fa fa-phone"></i>тел.(068)-353-56-30</a>
                        </li>
                    </ul>
                </div>
      </div>
    </header>
