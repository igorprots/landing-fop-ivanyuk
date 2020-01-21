<?php  /* Template Name: Home Page */ get_header(); ?>

    <div class="wrapper">
        <div class="container">

            <section class="service" id="service">
                <div class="row">
                    <div class="col-lg-4 ml-auto">
                        <h2 class="text-center text-uppercase">Iнженерно-геодезичнi роботи
                        </h2>
                        <ul>
                            <li>Lorem ipsum dolor sit, amet consectetur </li>
                            <li>Lorem, ipsum dolor sit amet consectetur </li>
                            <li>Lorem, ipsum dolor sit amet consectetur </li>
                            <li>Lorem, ipsum dolor sit amet consectetur </li>
                            <li>Lorem, ipsum dolor sit amet consectetur </li>
                            <li>Lorem, ipsum dolor sit amet consectetur </li>
                            <li>Lorem, ipsum dolor sit amet consectetur </li>
                            <li>Lorem, ipsum dolor sit amet consectetur </li>
                            <li>Lorem, ipsum dolor sit amet consectetur </li>
                            <li>Lorem, ipsum dolor sit amet consectetur </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 mr-auto">
                        <h2 class="text-center text-uppercase">Проектнi <br>роботи
                        </h2>
                        <ul>
                            <li>Lorem ipsum dolor sit, amet consectetur </li>
                            <li>Lorem, ipsum dolor sit amet consectetur </li>
                            <li>Lorem, ipsum dolor sit amet consectetur </li>
                            <li>Lorem, ipsum dolor sit amet consectetur </li>
                            <li>Lorem, ipsum dolor sit amet consectetur </li>
                            <li>Lorem, ipsum dolor sit amet consectetur </li>
                            <li>Lorem, ipsum dolor sit amet consectetur </li>
                            <li>Lorem, ipsum dolor sit amet consectetur </li>
                            <li>Lorem, ipsum dolor sit amet consectetur </li>
                            <li>Lorem, ipsum dolor sit amet consectetur </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 mr-auto">
                        <h2 class="text-center text-uppercase">Будiвельнi <br>роботи
                        </h2>
                        <ul>
                            <li>Lorem ipsum dolor sit, amet consectetur
                            </li>
                            <li>Lorem, ipsum dolor sit amet consectetur a
                            </li>
                            <li>Lorem, ipsum dolor sit amet consectetur a
                            </li>
                            <li>Lorem, ipsum dolor sit amet consectetur a
                            </li>
                            <li>Lorem, ipsum dolor sit amet consectetur a
                            </li>
                            <li>Lorem, ipsum dolor sit amet consectetur a
                            </li>
                            <li>Lorem, ipsum dolor sit amet consectetur a
                            </li>
                            <li>Lorem, ipsum dolor sit amet consectetur a
                            </li>
                            <li>Lorem, ipsum dolor sit amet consectetur a
                            </li>
                            <li>Lorem, ipsum dolor sit amet consectetur a
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <div class="row grid-list-wrapper no-gutter-space " id=" shots">

                <section class="petition" id="petition">
                    <h1>Залишити заявку</h1>
                    <div class="row">
                        <div class="col-lg-12 mx-auto">
                            <form name=" sentMessage " id=" contactForm " novalidate=" novalidate " action="send.php" method="post">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Послуга</label>
                                    <select name="service" class="form-control" id="exampleFormControlSelect1">
                                        <option>Інженерно-геодезичні роботи</option>
                                        <option>Проектні роботи</option>
                                        <option>Будівельні роботи</option>
                                    </select>
                                </div>
                                <div class="control-group">
                                    <div class="form-group floating-label-form-group controls mb-0 pb-2">
                                        <label>Ім'я</label>
                                        <input name="fio" class="form-control " id=" name " type=" text " placeholder=" Ім 'я" required="required" data-validation-required-message="Please enter your name.">
                                        <p class="help-block text-danger"></p>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="form-group floating-label-form-group controls mb-0 pb-2">
                                        <label>Email </label>
                                        <input name="email" class="form-control" id="email" type="email" placeholder="Email" required="required" data-validation-required-message="Please enter your email address.">
                                        <p class="help-block text-danger"></p>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="form-group floating-label-form-group controls mb-0 pb-2">
                                        <label>Номер телефону</label>
                                        <input name="phonenumber" class="form-control" id="phone" type="tel" placeholder="Номер телефону" required="required" data-validation-required-message="Please enter your phone number.">
                                        <p class="help-block text-danger"></p>
                                    </div>
                                </div>
                                <br>
                                <div id="success"></div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-xl" id="sendMessageButton">Відправити</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>

                <section class="portfolio " id="portfolio">
                    <div class="container-fluid"></div>
                    <div class="row">
                        <div class="col-lg-3 col-sm-6">
                            <a class="portfolio-box " href="/img/blog/01.jpg">
                                <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/blog/01.jpg " alt="">
                                <div class="portfolio-box-caption">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <a class="portfolio-box " href="/img/blog/02.jpg">
                                <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/blog/02.jpg " alt="">
                                <div class="portfolio-box-caption">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <a class="portfolio-box " href=" img/blog/03.jpg">
                                <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/blog/03.jpg " alt="">
                                <div class="portfolio-box-caption">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <a class="portfolio-box " href=" img/blog/03.jpg">
                                <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/blog/03.jpg " alt="">
                                <div class="portfolio-box-caption">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <a class="portfolio-box " href=" img/blog/03.jpg">
                                <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/blog/03.jpg " alt="">
                                <div class="portfolio-box-caption">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <a class="portfolio-box " href=" img/blog/03.jpg">
                                <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/blog/03.jpg " alt="">
                                <div class="portfolio-box-caption">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <a class="portfolio-box " href=" img/blog/03.jpg">
                                <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/blog/03.jpg " alt="">
                                <div class="portfolio-box-caption">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <a class="portfolio-box " href=" img/blog/03.jpg">
                                <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/blog/03.jpg " alt="">
                                <div class="portfolio-box-caption">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <a class="portfolio-box " href=" img/blog/03.jpg">
                                <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/blog/03.jpg " alt="">
                                <div class="portfolio-box-caption">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <a class="portfolio-box " href=" img/blog/03.jpg">
                                <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/blog/03.jpg " alt="">
                                <div class="portfolio-box-caption">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <a class="portfolio-box " href=" img/blog/03.jpg">
                                <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/blog/03.jpg " alt="">
                                <div class="portfolio-box-caption">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <a class="portfolio-box " href=" img/blog/03.jpg">
                                <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/blog/03.jpg " alt="">
                                <div class="portfolio-box-caption">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <a class="portfolio-box " href=" img/blog/03.jpg">
                                <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/blog/03.jpg " alt="">
                                <div class="portfolio-box-caption">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <a class="portfolio-box " href=" img/blog/03.jpg">
                                <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/blog/03.jpg " alt="">
                                <div class="portfolio-box-caption">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <a class="portfolio-box " href=" img/blog/03.jpg">
                                <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/blog/03.jpg " alt="">
                                <div class="portfolio-box-caption">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <a class="portfolio-box " href=" img/blog/03.jpg">
                                <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/blog/03.jpg " alt="">
                                <div class="portfolio-box-caption">
                                </div>
                            </a>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

<?php get_footer(); ?>
