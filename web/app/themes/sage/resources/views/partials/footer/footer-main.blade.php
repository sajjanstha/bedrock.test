<footer class="theme-footer">
    <section class="theme-footer__info">
        <div class="container d-flex items-start flex-column ht-100">
            <div class="row justify-content-between theme-footer__top">
                <div class="col-lg-3 d-flex justify-content-center justify-content-lg-start pb-5 pb-lg-0">

                    <?php while (have_rows('footer_first_logo', 'option')):the_row();
                        $image = get_sub_field('image'); ?>
                        <div class="theme-footer__logo">
                            <a href="/" title="<?php echo $image['title']; ?>"><img
                                        src="<?php echo $image['url']; ?>"
                                        class="img-fluid"
                                        alt="<?php echo $image['alt']; ?>"/>
                            </a>
                            <p class="pt-24">
                                <?php the_sub_field('logo_info'); ?>
                            </p>
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="col-lg-7 pt-3 pt-lg-0">
                    <div class="theme-footer__visitNepal">
                        <?php $images = get_field('footer_second_logo', 'option'); ?>
                        <?php if ($images): ?>
                            <ul class="list-unstyled list-inline text-center text-lg-right">
                                <?php foreach ($images as $image): ?>
                                    <li class="list-inline-item"><img
                                                src="<?php echo $image['url'] ?>"
                                                class="img-fluid" alt="Nepal 2020"/></li>
                                <?php endforeach; ?>

                            </ul>
                        <?php endif; ?>

                        <!-- <div class="row d-flex align-items-center">
                            <div class="col-6 text-right">
                                <img src="<?php echo get_theme_file_uri('assets/images/logo-2020.svg') ?>" class="img-fluid" alt="Nepal 2020" />
                            </div>
                            <div class="col-6">
                                <img src="<?php echo get_theme_file_uri('assets/images/le-mark.svg') ?>" class="img-fluid" alt="Nepal 2020" />
                            </div>
                        </div> -->
                    </div>

                </div>

            </div>
            <div class="row d-flex justify-content-center text-center theme-footer__signup">

                <!--                <form action="JavaScript:void(0)" name="2020signup" class="theme-footer__signup-form" id="newsletter-form">-->
                <?php echo do_shortcode('[contact-form-7 id="101" title="Subscribe now footer"]') ?>
                <!--                </form>-->
            </div>

            <div
                    class="row theme-footer__copyright theme-footer__tourism d-flex justify-content-between align-items-center">
                <div class="col-lg-4 p-0">
                    <p class="text-center text-lg-left">
                        <?php $copyright = get_field('footer_copyright', 'option');
                        echo $copyright;
                        ?>
                    </p>
                </div>

                <div class="col-lg-4 d-flex justify-content-center py-4 py-lg-0 ">
                    <ul class="social-icons">
                        <?php
                        $fbLink = get_field('footer_fb_link', 'option');
                        $instaLink = get_field('footer_insta_link', 'option');
                        ?>
                        <?php if ($fbLink): ?>
                            <li><a href="<?php echo $fbLink ?>" Target="_blank"
                                   class="social-icon"> <i class="fa fa-facebook"></i></a></li>
                        <?php endif; ?>
                        <?php if ($instaLink): ?>
                            <li><a href="<?php echo $instaLink ?>" Target="_blank"
                                   class="social-icon">
                                    <i class="fa fa-instagram"></i></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-lg-4 d-flex align-items-center justify-content-center justify-content-lg-end theme-footer__ntm p-0">
                    In co-ordination with
                    <?php while (have_rows('footer_coordinate_with', 'option')):the_row();
                        $image = get_sub_field('image'); ?>
                        <a href="<?php the_sub_field('image_link'); ?>" target="_blank"><img
                                    src="<?php echo $image['url']; ?>"
                                    class="img-fluid ntm" alt="<?php echo $image['alt']; ?>"/></a> &nbsp;
                    <?php endwhile; ?>
                    </a>
                </div>

            </div>
    </section>
</footer>

<?php get_template_part('template-parts/footer/footer', 'contact'); ?>
<?php get_template_part('template-parts/footer/footer', 'scripts'); ?>
