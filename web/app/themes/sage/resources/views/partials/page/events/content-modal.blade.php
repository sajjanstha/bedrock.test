<div class="modal modal--news modal--fullwidth fade bg-white" id="eventModal<?php the_ID() ?>"
    data-post_id="<?php the_ID() ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container-fluid ht-100">
                    <div class="row justify-content-between align-items-center ht-100">
                        <div class="col d-flex justify-content-start">
                            <a href="<?php echo '/events' ?>"
                                class="close text-uppercase text-primary align-items-center link--dark d-flex flex-row <?php echo !is_single() ? 'pv-modal-link' : '' ?>"
                                data-reload="false"
                                aria-label="Close">
                                <img src="<?php echo get_theme_file_uri("assets/images/previous.svg") ?>" class="back"
                                    alt="back icon" />
                                <span>Back to Calendar Page</span>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-body modal-events">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-9">
                            <div class="row justify-content-sm-end">
                                <div class="col-lg-9">
                                    <div class="modal--news__main">
                                        <header class="modal--news__header">
                                            <h3 class="modal--news__main-title">
                                                <?php the_title() ?>
                                            </h3>
                                        </header>
                                    </div>
                                </div>
                            </div>
                            <?php if ( has_post_thumbnail() ): ?>
                            <div class="row">
                                <div class="col">
                                    <main class="modal--news__desc">

                                        <figure class="modal--news__img modal-events__img text-center">
                                            <div class="card-date z-index-10">
                                                 {!! App\get_short_event_date(get_post()) !!}
                                            </div>
                                            <?php the_post_thumbnail('post-thumbnail', array('style' => 'max-width: 100%; max-height: 100%; height: auto;')) ?>
                                        </figure>
                                    </main>
                                </div>
                            </div>
                            <?php endif; ?>
<!--                            <div class="row">-->
<!--                                <div class="col d-flex justify-content-end">-->
<!--                                    <span>-->
<!--                                        <img src="--><?php //echo get_theme_file_uri("assets/images/previous-gallery.svg") ?><!--"-->
<!--                                            class="modal-events__nav previous" alt="back icon" />-->
<!--                                    </span>-->
<!--                                    <a href="javascript:void(0);" class="">-->
<!--                                        <img src="--><?php //echo get_theme_file_uri("assets/images/next-gallery-link.svg") ?><!--"-->
<!--                                            class="modal-events__nav next" alt="back icon" />-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="row justify-content-sm-end modal-events__content">
                                <div class="col-lg-9">
                                    <div class="p-news newspaper">
                                        <?php the_content(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
