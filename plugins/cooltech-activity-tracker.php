<?php
/*
Plugin Name: CoolTech Activity Tracker
Plugin URI: https://www.hyperiondev.com/
Description: A plugin to log and return the views of posts 
Version: 1.0
Author: Katherine Van As
Author URI: https://www.hyperiondev.com/
License: UNLICENSED
*/


if ( !defined( 'ABSPATH' ) ) exit;

// On plugin install - check if tables exist if not add table prefix_cooltech_tracker
function cooltech_tracker_install(){

    global  $wpdb;

    $tracking_table = $wpdb->prefix.'cooltech_tracker';

    if( $wpdb->get_var( "show tables like `{$tracking_table}`" ) === $tracking_table ) {
        return null;
    }    

    $sql =  "CREATE TABLE IF NOT EXISTS `{$tracking_table}` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `post_id` int(11) NOT NULL,
        `viewed_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=latin1";

    // Include Upgrade Script
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

    dbDelta( $sql );

}
register_activation_hook( __FILE__, 'cooltech_tracker_install' );


//On single post/page view insert to table 
//postId, timestamp
function cooltech_new_activity_log()
{
    if (!is_single()) return null;

    global  $wpdb;
    global $post;

    $table = $wpdb->prefix.'cooltech_tracker';
    $data = array('post_id' => $post->ID);
    $format = array('%d');
    $wpdb->insert($table,$data,$format);

}
add_action('wp_head', 'cooltech_new_activity_log');


//on any post request return postcount
function cooltech_get_stat()
{

    global $post; // post in question
    global  $wpdb;

    $views = $wpdb->get_var("select count(*) from `{$wpdb->prefix}cooltech_tracker` where post_id = {$post->ID}");
    
    return '<strong>'.shortNumber($views).'</strong> views';    
}

function cooltech_get_hour_stat()
{

    global $post; // post in question
    global  $wpdb;

    $views = $wpdb->get_var("select count(*) from `{$wpdb->prefix}cooltech_tracker` where post_id = {$post->ID} AND viewed_at > DATE_SUB(NOW(), INTERVAL 1 HOUR) ");
    
    return '<strong>'.shortNumber($views).'</strong> views in the last hour';    
}


/* Gets the top 10 hottest posts in the last hour, ordered by views descending */
function cooltech_hot_right_now()
{
    global $post; // post in question
    global  $wpdb;
    
    $hotposts = $wpdb->get_results("select post_id, count(*) from `{$wpdb->prefix}cooltech_tracker` 
    where viewed_at > DATE_SUB(NOW(), INTERVAL 1 HOUR) 
    group by post_id order by count(*) desc  limit 10");

    $hotpostArr = [];
    foreach($hotposts as $postid){
        array_push($hotpostArr, $postid->post_id);
    }

    // nothing is hot, send -1 back so wp query will not be able to find an post id we know does not exist
    if(empty($hotpostArr)){
        array_push($hotpostArr, -1);
    }


    return $hotpostArr;
}

// Shorten view counts in the 1000s and millions  
function shortNumber($num) 
{
    if ($num > 999999) {
        $num = floor($num / 1000000) . 'M';
    }
    elseif ($num > 999) {
        $num = floor($num / 1000) . 'K';
    }
    echo $num;
}


/* 
***********SUPER HOT, HOT RIGHT NOW FEATURE ******************
In the CMS this can be accessed by dropping in a query loop block with a search for ":hot-right-now".
The query is reset just before it runs to fetch the hottest posts in the last hour 
returned from the cooltech_hot_right_now() function (above)
*/
function cooltech_switch_out_query ( \WP_Query $q ) {

    if ( $q->is_search() && ':hot-right-now' === trim( $q->get( 's' ) ) ) {
        // Custom taxonomy query.
        $q->set('s', null);
        $q->set('post__in', cooltech_hot_right_now());
        $q->set('orderby', 'post__in');
        
        
    }
   
}
add_action( 'pre_get_posts', 'cooltech_switch_out_query');






