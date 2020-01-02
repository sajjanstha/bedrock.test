<?php

namespace App;

use Roots\Sage\Container;

/**
 * Get the sage container.
 *
 * @param string $abstract
 * @param array  $parameters
 * @param Container $container
 * @return Container|mixed
 */
function sage($abstract = null, $parameters = [], Container $container = null)
{
    $container = $container ?: Container::getInstance();
    if (!$abstract) {
        return $container;
    }
    return $container->bound($abstract)
        ? $container->makeWith($abstract, $parameters)
        : $container->makeWith("sage.{$abstract}", $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param array|string $key
 * @param mixed $default
 * @return mixed|\Roots\Sage\Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return sage('config');
    }
    if (is_array($key)) {
        return sage('config')->set($key);
    }
    return sage('config')->get($key, $default);
}

/**
 * @param string $file
 * @param array $data
 * @return string
 */
function template($file, $data = [])
{
    return sage('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view
 * @param $file
 * @param array $data
 * @return string
 */
function template_path($file, $data = [])
{
    return sage('blade')->compiledPath($file, $data);
}

/**
 * @param $asset
 * @return string
 */
function asset_path($asset)
{
    return sage('assets')->getUri($asset);
}

/**
 * @param string|string[] $templates Possible template files
 * @return array
 */
function filter_templates($templates)
{
    $paths = apply_filters('sage/filter_templates/paths', [
        'views',
        'resources/views'
    ]);
    $paths_pattern = "#^(" . implode('|', $paths) . ")/#";

    return collect($templates)
        ->map(function ($template) use ($paths_pattern) {
            /** Remove .blade.php/.blade/.php from template names */
            $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

            /** Remove partial $paths from the beginning of template names */
            if (strpos($template, '/')) {
                $template = preg_replace($paths_pattern, '', $template);
            }

            return $template;
        })
        ->flatMap(function ($template) use ($paths) {
            return collect($paths)
                ->flatMap(function ($path) use ($template) {
                    return [
                        "{$path}/{$template}.blade.php",
                        "{$path}/{$template}.php",
                    ];
                })
                ->concat([
                    "{$template}.blade.php",
                    "{$template}.php",
                ]);
        })
        ->filter()
        ->unique()
        ->all();
}

/**
 * @param string|string[] $templates Relative path to possible template files
 * @return string Location of the template
 */
function locate_template($templates)
{
    return \locate_template(filter_templates($templates));
}

/**
 * Determine whether to show the sidebar
 * @return bool
 */
function display_sidebar()
{
    static $display;
    isset($display) || $display = apply_filters('sage/display_sidebar', false);
    return $display;
}

if (!function_exists('get_short_event_date')) {
    function get_short_event_date($event)
    {
        $type = get_post_meta($event->ID, 'type', true);
        $startDateTime = get_post_meta($event->ID, 'start_date_time', true);
        switch ($type) {
            case 'Throughout Year':
                return "365<span class='month d-block pt-3'>days</span>";
                break;
            default:
                return date('d', strtotime($startDateTime)) . "<span class='month d-block pt-3'>" . date('M', strtotime($startDateTime)) . "</span>";
        }
    }
}

function get_youtube_thumbnail_from_id($video_id, $quality = 'high')
{
    $base_url = 'http://img.youtube.com/vi/';
    switch ($quality) {
        case 'low':
            $image_url = $base_url . $video_id . '/sddefault.jpg';
            break;

        case 'medium':
            $image_url = $base_url . $video_id . '/mqdefault.jpg';
            break;

        case 'high':
            $image_url = $base_url . $video_id . '/hqdefault.jpg';
            break;

        case 'max':
            $image_url = $base_url . $video_id . '/maxresdefault.jpg';
            break;
        default:
            return 'Choose The Quality Between [ LOW (or) MEDIUM  (or) HIGH  (or)  MAXIMUM]';
            break;
    }
    return $image_url;
}


function get_video_thumbnail_uri($video_uri)
{

    $thumbnail_uri = '';


    // determine the type of video and the video id
    $video = parse_video_uri($video_uri);


    // get youtube thumbnail
    if ($video['type'] == 'youtube')
        $thumbnail_uri = 'http://img.youtube.com/vi/' . $video['id'] . '/hqdefault.jpg';

    // get vimeo thumbnail
    if ($video['type'] == 'vimeo')
        $thumbnail_uri = get_vimeo_thumbnail_uri($video['id']);
    // get wistia thumbnail
    if ($video['type'] == 'wistia')
        $thumbnail_uri = get_wistia_thumbnail_uri($video_uri);
    // get default/placeholder thumbnail
    if (empty($thumbnail_uri) || is_wp_error($thumbnail_uri))
        $thumbnail_uri = '';

    //return thumbnail uri
    return $thumbnail_uri;

}


/**
 * Parse the video uri/url to determine the video type/source and the video id
 */
function parse_video_uri($url)
{

    // Parse the url
    $parse = parse_url($url);
//    dump($parse);
    // Set blank variables
    $video_type = '';
    $video_id = '';

    // Url is http://youtu.be/xxxx
    if ($parse['host'] == 'youtu.be') {

        $video_type = 'youtube';

        $video_id = ltrim($parse['path'], '/');

    }

    // Url is http://www.youtube.com/watch?v=xxxx
    // or http://www.youtube.com/watch?feature=player_embedded&v=xxx
    // or http://www.youtube.com/embed/xxxx
    if (($parse['host'] == 'youtube.com') || ($parse['host'] == 'www.youtube.com')) {

        $video_type = 'youtube';

        parse_str($parse['query'], $result);
//        dd($result);
        $video_id = $result['v'];

        if (!empty($result['feature']))
            $video_id = end(explode('v=', $parse['query']));

        if (strpos($parse['path'], 'embed') == 1)
            $video_id = end(explode('/', $parse['path']));

    }

    // Url is http://www.vimeo.com
    if (($parse['host'] == 'vimeo.com') || ($parse['host'] == 'www.vimeo.com')) {

        $video_type = 'vimeo';

        $video_id = ltrim($parse['path'], '/');

    }
    $host_names = explode(".", $parse['host']);
    $rebuild = (!empty($host_names[1]) ? $host_names[1] : '') . '.' . (!empty($host_names[2]) ? $host_names[2] : '');
    // Url is an oembed url wistia.com
    if (($rebuild == 'wistia.com') || ($rebuild == 'wi.st.com')) {

        $video_type = 'wistia';

        if (strpos($parse['path'], 'medias') == 1)
            $video_id = end(explode('/', $parse['path']));

    }

    // If recognised type return video array
    if (!empty($video_type)) {

        $video_array = array(
            'type' => $video_type,
            'id' => $video_id
        );

        return $video_array;

    } else {

        return false;

    }

}


/* Takes a Vimeo video/clip ID and calls the Vimeo API v2 to get the large thumbnail URL.
*/
function get_vimeo_thumbnail_uri($clip_id)
{
    $vimeo_api_uri = 'http://vimeo.com/api/v2/video/' . $clip_id . '.php';
    $vimeo_response = wp_remote_get($vimeo_api_uri);
    if (is_wp_error($vimeo_response)) {
        return $vimeo_response;
    } else {
        $vimeo_response = unserialize($vimeo_response['body']);
        return $vimeo_response[0]['thumbnail_large'];
    }

}

/**
 * Takes a wistia oembed url and gets the video thumbnail url.
 */
function get_wistia_thumbnail_uri($video_uri)
{
    if (empty($video_uri))
        return false;
    $wistia_api_uri = 'http://fast.wistia.com/oembed?url=' . $video_uri;
    $wistia_response = wp_remote_get($wistia_api_uri);
    if (is_wp_error($wistia_response)) {
        return $wistia_response;
    } else {
        $wistia_response = json_decode($wistia_response['body'], true);
        return $wistia_response['thumbnail_url'];
    }

}

function get_finalized_date($post)
{
    $type = get_post_meta($post->ID, 'type', true);
    $isDateFinalized = get_post_meta($post->ID, 'is_date_finalized', true);
    $startDateTime = get_post_meta($post->ID, 'start_date_time', true);
    $endDateTime = get_post_meta($post->ID, 'end_date_time', true);

    $startDateDay = date('d', strtotime($startDateTime));
    $startDateMonth = date('M', strtotime($startDateTime));
    $startDateYear = date('Y', strtotime($startDateTime));
    $endDateDay = date('d', strtotime($endDateTime));
    $endDateMonth = date('M', strtotime($endDateTime));
    $endDateYear = date('Y', strtotime($endDateTime));

    if (!empty($isDateFinalized) || $isDateFinalized == true) {
        switch ($type) {
            case 'Throughout Year':
                return "<div>365<span class='year text-black d-block'>days</span></div>";
                break;
            case 'Single Day':
                return "<div>" . $startDateDay . "<span class='month d-block'>" . $startDateMonth . "</span>" . "<span class='year text-black d-block'>" . $startDateYear . "</span></div>";
                break;
            case 'Multiple Days':
                return "<div>" . $startDateDay . "<span class='month d-block'>" . $startDateMonth . "</span>" . "<span class='year text-black d-block'>" . $startDateYear . "</span></div><div class='mx-3'>-</div><div>" . $endDateDay . "<span class='month d-block'>" . $endDateMonth . "</span>" . "<span class='year text-black d-block'>" . $endDateYear . "</span></div>";
                break;
            default:
                return $startDateDay . "<span class='month d-block pt-3'>" . $startDateMonth . "</span>";
        }
    }
    switch ($type) {
        case 'Throughout Year':
            return "<div>365<span class='year text-black d-block '>days</span></div>";
            break;
        case 'Single Day':
            return "<div>" . $startDateMonth . "<span class='year text-black d-block '>" . $startDateYear . "</span></div>";
            break;
        case 'Multiple Days':
            if ($startDateMonth == $endDateMonth && $startDateYear == $endDateYear) {
                return "<div>" . $startDateMonth . "<span class='year text-black d-block '>" . $startDateYear . "</span></div>";
            }
            if ($startDateMonth != $endDateMonth || $startDateYear != $endDateYear) {
                return "<div>" . $startDateMonth . "<span class='year text-black d-block '>" . $startDateYear . "</span></div><div class='mx-3'>-</div>" . "<div>" . $endDateMonth . "<span class='year text-black d-block '>" . $endDateYear . "</span></div>";
            }
            break;
        default:
            return "<div>" . $startDateMonth . "<span class='year text-black d-block '>" . $startDateYear . "</span></div>";
    }
}

function get_previous_starting_post($current_post, $sorting_meta_key) {
    $previous_post = null;
    wp_reset_postdata();
    $start_date_time = get_post_meta($current_post->ID, $sorting_meta_key, true);
    $type = get_post_meta($current_post->ID, 'type', true);

    if ($type == 'Throughout Year') {
        $arguments = array(
            'post_type' => $current_post->post_type,
            'posts_per_page' => 1,
            'post__not_in' => [$current_post->ID],
            'meta_query' => array(
                array(
                    'key' => 'type',
                    'compare' => '=',
                    'value' => 'Throughout Year',
                ),
            ),
            'date_query' => array(
                'before'  => $current_post->post_date,
            ),
            'orderby' => 'date',
            'order'   => 'DESC',
        );
    } else {
        $arguments = array(
            'post_type' => $current_post->post_type,
            'posts_per_page' => 1,
            'post__not_in' => [$current_post->ID],
            'meta_query' => array(
                'key' => $sorting_meta_key,
                'compare' => '<=',
                'value' => $start_date_time,
            ),
            'orderby'   => 'meta_value',
            'order'   => 'DESC',
            'meta_key'  => $sorting_meta_key,
        );
    }

    $previous_post_query = new WP_Query($arguments);
    while ($previous_post_query->have_posts()) {
        $previous_post_query->the_post();
        $previous_post = $previous_post_query->post;
    }
    wp_reset_postdata();

    return $previous_post;
}

function get_next_starting_post($current_post, $sorting_meta_key) {
    $next_post = null;
    wp_reset_postdata();
    $start_date_time = get_post_meta($current_post->ID, $sorting_meta_key, true);
    $type = get_post_meta($current_post->ID, 'type', true);

    if ($type == 'Throughout Year') {
        $arguments = array(
            'post_type' => $current_post->post_type,
            'posts_per_page' => 1,
            'post__not_in' => [$current_post->ID],
            'meta_query' => array(
                array(
                    'key' => 'type',
                    'compare' => '=',
                    'value' => 'Throughout Year',
                ),
            ),
            'date_query' => array(
                'after'  => $current_post->post_date,
            ),
            'orderby' => 'date',
            'order'   => 'ASC',
        );
    } else {
        $arguments = array(
            'post_type' => $current_post->post_type,
            'posts_per_page' => 1,
            'post__not_in' => [$current_post->ID],
            'meta_query' => array(
                'key' => $sorting_meta_key,
                'compare' => '>=',
                'value' => $start_date_time,
            ),
            'orderby'   => 'meta_value',
            'order'   => 'ASC',
            'meta_key'  => $sorting_meta_key,
        );
    }
    $next_post_query = new WP_Query($arguments);
    while ($next_post_query->have_posts()) {
        $next_post_query->the_post();
        $next_post = $next_post_query->post;
    }
    wp_reset_postdata();

    return $next_post;
}


// array of filters (field key => field name)
$GLOBALS['event_date_filters'] = array(
    '1' => 'Jan',
    '2' => 'Feb',
    '3' => 'Mar',
    '4' => 'Apr',
    '5' => 'May',
    '6' => 'Jun',
    '7' => 'Jul',
    '8' => 'Aug',
    '9' => 'Sep',
    '10' => 'Oct',
    '11' => 'Nov',
    '12' => 'Dec',
);
