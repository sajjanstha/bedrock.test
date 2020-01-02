@extends('layouts.app')

@section('content')
<div class="theme-app d-flex flex-column">
  <div class="theme-wrap">
    <!-- Site Overlay -->
    <section class="site-overlay"></section>
    <main class="theme-main">
      @include( 'partials.header.header-main' )
      <section class="above-the-fold">
        <div id="carouselExampleIndicators" class="carousel carousel-hero slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-caption">
              <div class="container">
                <div class="row text-left">
                  <div class="col-12 col-md-7 offset-md-5">
                    <h1 class="text-uppercase">
                    </h1>
                  </div>
                </div>
              </div>
            </div>

            <div class="carousel-item__innerpages active">
              <img src="<?php echo get_theme_file_uri("assets/images/news-hero-bg-thumb.jpg") ?>"
                   class="carousel-img lazy bg-lazyloading" alt="Visit Nepal 2020" width="100%"
                   height="100%" data-img="true"
                   data-src="<?php echo get_theme_file_uri("assets/images/news-hero-bg@2x.jpg") ?>" />
            </div>
          </div>
        </div>
      </section>
      <!-- End of above the fold -->

      <!-- Start of Newsroom session -->
      <section class="theme-content content-gutter pb-0 pt-0 z-index-25" id="news">
        <div id="wrap position-relative">
          <div class="container">
            <div class="theme-innerpages theme-gallery theme-events pb-0 theme-gallery__single position-relative">
              <div class="row justify-content-center">
                <div class="col-lg-10">
                  <div class="row">
                    <div class="col-lg-7">
                      <span class="theme-content__skewed text-uppercase">Events</span>
                      <h2 class="mb-0 py-4 py-sm-0">
                        2020 Special Events
                      </h2>

                    </div>

{{--                    @include('partials.filters.filters-year_month')--}}
                    <?php
                    $currentYear = max('2020', date('Y'));
                    $post_type = get_post_type();
                    $current_page = max(get_query_var('paged'), 1);
                    $selected_month = isset($_GET['month']) ? $_GET['month'] : '';
                    $selected_yr = isset($_GET['yr']) ? $_GET['yr'] : $currentYear;
                    if ($selected_yr == 'through_out_year') {
                      $meta_sort_query = array(
                        array(
                          'key' => 'type',
                          'compare' => '=',
                          'value' => 'Throughout Year',
                        )
                      );
                      $arguments = array(
                        'post_type' => $post_type,
                        'posts_per_page' => get_option('posts_per_page'),
                        'paged' => $current_page,
                        'meta_query' => $meta_sort_query,
                        'orderby' => 'date',
                        'order'   => 'ASC',
                      );
                    } else {
                      $default_month = $selected_month ? $selected_month : '01';
                      $lower_limit = $selected_yr.date('-01-01');
                      $upper_limit = $selected_yr.date('-12-t');

                      $first_date_of_month = $selected_yr.'-'.$default_month.'-1';
                      if ($selected_month) {
                        $lower_limit = $first_date_of_month = $selected_yr.date('-m-01', strtotime($first_date_of_month));
                        $upper_limit = $last_day_of_month = $selected_yr.date('-m-t', strtotime($first_date_of_month));
                      }
                      $meta_sort_query = array(
                        'relation' => 'AND',
                        array(
                          'relation' => 'OR',
                          array(
                            'relation' => 'AND',
                            array(
                              'key' => 'start_date_time',
                              'compare' => '>=',
                              'value' => $lower_limit,
                            ),
                            array(
                              'key' => 'start_date_time',
                              'compare' => '<=',
                              'value' => $upper_limit,
                            )
                          ),
                          array(
                            'relation' => 'AND',
                            array(
                              'key' => 'end_date_time',
                              'compare' => '>=',
                              'value' => $lower_limit,
                            ),
                            array(
                              'key' => 'end_date_time',
                              'compare' => '<=',
                              'value' => $upper_limit,
                            )
                          )
                        )
                      );
                      $arguments = array(
                        'post_type' => $post_type,
                        'posts_per_page' => get_option('posts_per_page'),
                        'paged' => $current_page,
                        'meta_query' => $meta_sort_query,
                        'orderby' => 'meta_value',
                        'order' => 'ASC',
                        'meta_key'  => 'start_date_time',
                      );
                    }

                    $the_query = new WP_Query($arguments);
                    $prev_post_img = '<img src="' . get_theme_file_uri("assets/images/back-pagination.svg") . '" class="previous" alt="back icon" />';
                    $next_post_img = '<img src="' . get_theme_file_uri("assets/images/forward-pagination.svg") . '" class="next" alt="forward icon" />';
                    $firstPageUrl = get_pagenum_link(1);
                    $lastPageUrl = get_pagenum_link($the_query->max_num_pages);
                    ?>
                    <div class="col-lg-5 d-flex pt-4 pt-lg-0 justify-content-lg-end align-items-center">
                      <div class="container">
                        <div class="row d-flex align-items-center">
                          <div class="col text-left text-lg-right px-0 theme-content__wrap-txt mr-4">Search by</div>
                          <div class="col px-0">
                            <form action="<?php echo get_post_type_archive_link($post_type) ?>" method="get" class="w-100 d-flex">
                              <?php if ($selected_yr != 'through_out_year'): ?>
                              <div class="mr-4 w-50">
                                <select id="month-filter" name="month" class="custom-select">
                                  <option value="">Month</option>
                                  <?php foreach ($GLOBALS['event_date_filters'] as $mid => $month): ?>
                                  <option value="<?php echo $mid ?>" <?php echo $selected_month == $mid ? 'selected' : '' ?>>
                                    <?php echo $month ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                              <?php endif; ?>

                              <div class="w-50">
                                <select id="year-filter" name="yr" class="custom-select">
                                  <?php if ($post_type == 'events'): ?>
                                  <option value="through_out_year">Through Out Year</option>
                                  <?php endif; ?>
                                  <?php foreach (range($currentYear + 5, $currentYear-10) as $year): ?>
                                  <option value="<?php echo $year ?>" <?php echo $year == $selected_yr ? 'selected' : '' ?>>
                                    <?php echo $year ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                    </div>
                    <script type="text/javascript">
                      (function($) {
                        $('#month-filter').on('change', function() {
                          var $this = $(this);
                          $this.parents('form').submit();
                        });
                        $('#year-filter').on('change', function() {
                          var $this = $(this);
                          $this.parents('form').submit();
                        });
                      })(jQuery);
                    </script>

                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="theme-innerpages__bg match-height"></div>
          <div class="container theme-gallery__posts match-height">

            <div class="row pb-0 justify-content-center">
              <div class="col-lg-10">
                <div class="review-wrap d-flex flex-column flex-sm-row justify-content-between theme-events__single">

                <?php if ($the_query->have_posts()) : ?>
                <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                <!-- Start of Event -->
                @include('partials.page.events.content-post')
                <!-- End of Event -->
                  <?php endwhile; ?>
                  <?php else : ?>
                  <div class="review-wrap__review">
                    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                  </div>
                  <?php endif; ?>
                  <?php wp_reset_postdata(); ?>

                </div>

              </div>

            </div>
            <?php if ($the_query->found_posts): ?>
            <div class="theme-pagination">
              <div class="container">
                <div class="row">
                  <div class="col">
                    <div class="number-pager d-flex justify-content-center align-items-center">
                      <?php previous_posts_link($prev_post_img); ?>
                      <a href="javascript:;">
                        <span class="page-numbers"><?php echo $current_page; ?></span>
                      </a>
                      <span class="separator">/</span>
                      <a href="<?php echo $current_page != $the_query->max_num_pages ? $lastPageUrl : 'javascript:;' ?>">
                        <span class="page-numbers"><?php echo $the_query->max_num_pages ?></span>
                      </a>
                      <?php if ($current_page != $the_query->max_num_pages) next_posts_link($next_post_img); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </section>
      <!-- End of Newsroom section -->
    </main>
  </div>
  @include('partials.footer.footer-main')
</div>

<?php
$the_query->rewind_posts();
if ($the_query->have_posts()) :
  while ($the_query->have_posts()) : $the_query->the_post(); ?>
    @include('partials.page.events.content-modal')
<?php
  endwhile;
endif;
wp_reset_postdata();
?>
@endsection
