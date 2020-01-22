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

                        <?php echo do_shortcode('[contact-form-7 id="45" title="Головна сторінка"]'); ?>

                        </div>
                    </div>
                </section>







                <section class="portfolio " id="portfolio">
                    <div class="container-fluid"></div>
                    <div class="row">
                    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <?php the_content(); ?>
    </article
  <?php endwhile; endif; ?>
                    </div>
                </section>

            </div>
        </div>
    </div>

<?php get_footer(); ?>
