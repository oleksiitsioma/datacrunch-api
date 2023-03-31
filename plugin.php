<?php

/* 

Plugin name: Custom API Endpoint plugin
Author: Oleksii Tsioma
Author URI: https://www.linkedin.com/in/oleksiitsioma/
Description: Code Assessment plugin for Data Crunch
Version: 1.0


*/

function ___dcp_api_return_portfolio() {

    $posts = array();

    $queryArgs = array(
        'post_type'         => 'portfolio',
        'posts_per_page'    => 5,
        'post_status'       => 'publish'
    );

    if( $queryResults = get_posts( $queryArgs) ) {
        foreach ( $queryResults as $result ){

            $response = array(
                'id'                => $result->ID,
                'thumbnail'         => get_the_post_thumbnail_url( $result->ID , 'thumbnail' ),
                'title'             => $result->post_title,
                'excerpt'           => $result->post_excerpt,
                'skills'            => get_the_terms( $result->ID , 'skills' ),
            );

            $posts[] = $response;
        }
    }

    return $posts;
}

add_action( 'rest_api_init' , '___dcp_api_portfolio_endpoint' );

function ___dcp_api_portfolio_endpoint() {
    register_rest_route(
        'dcpapi/v1',
        '/portfolio',
        array(
            'methods'   => 'GET',
            'callback'  => '___dcp_api_return_portfolio',
            'permission_callback' => '__return_true',
        )
    );
}
