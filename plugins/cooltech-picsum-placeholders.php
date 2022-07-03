<?php
/*
Plugin Name: CoolTech Picsum Placeholders
Plugin URI: https://www.hyperiondev.com/
Description: A plugin that adds picsum images when there is no feature image
Version: 1.0
Author: Katherine Van As
Author URI: https://www.hyperiondev.com/
License: UNLICENSED
*/

function cooltech_picsum_placeholders_switch( $html) {

    // if a feature image is set return that image.
    if ($html !== '') {        
        return $html;
    }   

    global $post;
    $dimensions = ['width' => 760, 'height' => 440];
    if (is_archive())  $dimensions = ['width' => 450, 'height' => 350]; 
    if (is_single())  $dimensions =  ['width' => 1260, 'height' => 650]; 

    //rand(1,100) functions helps to ensure a variety of pics are returned for query loops
    $html = '<img  src="https://picsum.photos/'.$dimensions['width'].'/'.$dimensions['height'].'/?random='.rand(1,100).'.webp"  
                width="'.$dimensions['width'].'" height="'.$dimensions['height'].'"
                class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="Picsum"  />';
    return $html;
}
add_filter('post_thumbnail_html', 'cooltech_picsum_placeholders_switch');

