<header class="theme-header position-relative">
    <div class="container">
        <div class="row">
            <div class="col-9 col-lg-2">
                <div class="navbar-brand__bg">
                    <a class="p-0" href="/" title="Nepal 2020">
                        <?php
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                        if (has_custom_logo()) {
                            echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="img-fluid">';
                        } else {
                            echo '<h1>' . get_bloginfo('name') . '</h1>';
                        }
                        ?>
                    </a>
                </div>
            </div>

            <div class="col-3 col-lg-10">
                <nav class="navbar navbar-expand-lg justify-content-lg-between d-flex justify-content-end">
                    <div id="menuToggle">
                        <!--
                      A fake / hidden checkbox is used as click reciever,
                      so you can use the :checked selector on it.
                      -->
                        <input type="checkbox"/>

                        <!--
                      hamburger menu
                      -->
                        <span></span>
                        <span></span>
                        <span></span>

                        <?php wp_nav_menu([
                            'menu' => '',
                            'menu_id' => 'menu',
                            'container' => false,
                            'container_class' => '',
                            'container_id' => '',
                            'menu_class' => '',
                            'echo' => true,
                            'fallback_cb' => 'wp_page_menu',
                            'theme_location' => 'header_menu',
                            'items_wrap' => '<ul id="%1$s" class="%2$s ">%3$s</ul>',
                            'item_spacing' => 'preserve',
                            'depth' => 0,
                            'walker' => false
                        ]);
                        ?>

                    </div>

                    <div class="collapse navbar-collapse justify-content-end text-uppercase"
                         id="navbarSupportedContent">
                        <div class="d-flex justify-content-end align-items-center">
                            <?php wp_nav_menu([
                                'menu' => '',
                                'container' => false,
                                'container_class' => '',
                                'container_id' => '',
                                'menu_class' => 'navbar-nav align-items-center m-0',
                                'echo' => true,
                                'fallback_cb' => 'wp_page_menu',
                                'theme_location' => 'header_menu',
                                'items_wrap' => '<ul id="%1$s" class="%2$s ">%3$s</ul>',
                                'item_spacing' => 'preserve',
                                'depth' => 0,
                                'walker' => false
                            ]);
                            ?>
                        </div>
                    </div>
                </nav>
            </div>


        </div>
    </div>
</header>
