<?php

function twentytwentyone_styles()
{
    wp_enqueue_style(
        'child-style',
        get_stylesheet_uri(),
        array('twenty-twenty-one-style'),
        wp_get_theme()->get('Version')
    );
}

add_filter('rest_authentication_errors', 'block_unauthenticated_rest_requests');
add_action('wp_enqueue_scripts', 'twentytwentyone_styles');



function block_unauthenticated_rest_requests($result)
{
    global $wp;
    $protectedEndpoints = [
        "wp-json/wp/v2/users",
    ];
    $wp->request;
    if (
        in_array($wp->request, $protectedEndpoints) &&
        !is_user_logged_in()
    ) {
        return new WP_Error(
            'rest_not_logged_in',
            __('You are not currently logged in.'),
            array(
                'status' => 401
            )
        );
    }

    return $result;
}
