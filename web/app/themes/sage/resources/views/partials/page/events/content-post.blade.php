<div class="review-wrap__review">
    <div class="card-events">
        <a href="<?php the_permalink() ?>"
           class="theme-gallery__album-single--link link-black theme-events__link "
        >
            <div class="card-date z-index-10  card-date__multiple d-flex flex-row">

                <?php
                     //echo get_finalized_date(get_post());
                ?>
            </div>
            <figure class="theme-events__thumbnail">
                <?php if (has_post_thumbnail()): ?>

                <?php the_post_thumbnail('post-thumbnail', array('class' => 'img-cover' )); ?>
                <?php endif; ?>
            </figure>
            <div class="card-body card-events__body pt-4">
                <h5 class="card-title m-0"><?php the_title() ?></h5>
            </div>
        </a>

    </div>
</div>
