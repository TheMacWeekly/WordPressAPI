<?php
/*
Plugin Name:  The Mac Weekly REST API Extensions
Description:  Extend the REST API for The Mac Weekly's needs.
Version:      0.0.1
Author:       The Mac Weekly
Author URI:   https://themacweekly.com
License:      MIT
*/
use Molongui\Authorship\Includes\Author;

add_action( 'rest_api_init', function() {
    register_rest_field('post', 'guest_author', array(
        'get_callback' => function( $post_arr ) {
            $author = new Author();
            $author_id = $author->get_main_author( $post_arr['id']);
            $author_data = $author->get_data($author_id->id, $author_id->type);
            $author_data['img_url'] = get_the_post_thumbnail_url($author_id->id, "thumbnail");

            return $author_data;
        },
    ));
    register_rest_field('post', 'excerpt_plaintext', array(
        'get_callback' => function( $post_arr ) {
            return get_the_excerpt($post_arr['id']);
        },
    ));
    register_rest_field('post', 'normal_thumbnail_url', array(
         'get_callback' => function( $post_arr ) {
            $url = get_the_post_thumbnail_url($post_arr['id'], 'thumbnail');
              if ($url == false) {
                 return null;
              } else {
                 return $url;
              }
         },
    ));
    register_rest_field('post', 'full_thumbnail_url', array(
         'get_callback' => function( $post_arr ) {
            $url = get_the_post_thumbnail_url($post_arr['id'], 'large');
            if ($url == false) {
               return null;
            } else {
               return $url;
            }
         },
    ));
    register_rest_field('post', 'post_meta', array(
        'get_callback' => function( $post_arr ) {
            return get_post_meta( $post_arr['id']);
        },
    ));
})
?>
