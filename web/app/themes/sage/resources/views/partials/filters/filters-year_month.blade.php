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
