<div class="card">
    <div class="card-date card-date__multiple d-flex flex-row">
        <!-- Different Month -->
<!--            <div>29<span class="month d-block">Dec</span>-->
<!--                <span class="year text-black d-block">2019</span>-->
<!--            </div>-->
<!--            <div class="mx-3">-</div>-->
<!--            <div>3<span class="month d-block">Jan</span>-->
<!--                <span class="year text-black d-block ">2019</span>-->
<!--            </div>-->
        <!-- Same Month -->
            <!-- <div>Dec<span class="month d-block">21 - 29</span>
                <span class="year text-black d-block">2019</span>
            </div> -->
        <!-- Single Day -->
        <!-- <div>3<span class="month d-block">Jan</span>
                <span class="year text-black d-block ">2019</span>
            </div> -->
        <!-- Single Day Month and year only -->
        <!-- <div>Jan<span class="year text-black d-block ">2019</span>
            </div> -->
        <?php 
         echo get_finalized_date(get_post())
        ?>
    </div>
    <?php if (has_post_thumbnail()): ?>
    <?php the_post_thumbnail('post-thumbnail', array('class' => 'card-img-top img-cover' )); ?>
    <?php endif; ?>
    <div class="card-body">
        <h5 class="card-title"><?php the_title() ?></h5>
        <p class="card-text"><?php  echo truncate_content(get_the_content()); ?></p>
        <a href="<?php the_permalink() ?>"
            class="theme-link d-inline-flex align-items-center mt-4 card--news__link">
            See details<i class="right"></i>
        </a>
    </div>
</div>