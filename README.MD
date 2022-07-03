
# Cooltech Wordpress website

A Block based theme and a couple of plugins to handle missing feature images and logging post views.

This was my first time experimenting with Full Site Editing (FSE) themes - the raging new trend at Wordpress.


## How to use
* Install Wordpress 6.0+
* Add the Cooltech folder to  /themes/
* Add the two plugin php files to  /plugins 
* See below for additional and most third-party plugins required


## What I did

1. The cooltech-activity-tracker (see plugins/cooltech-activity-tracker.php)

    - this tracks logs page views and times in a separate table.
    - it can return the hits for each page 
    - the hits in the last hour
    - has an action hook to customise a query loop to return the "Hot right now" posts most visited in the last hour (its on the home page but because we are using blocks we can reuse the functionality anywhere and change the number of posts returned from the CMS - pretty neat!). To use add ":hot-right-now" into the query search

2. The Picsum Placeholder plugin (see plugins/cooltech-picsum-placeholders.php)

    - replaces missing feature images with images from https://picsum.photos/

3. Built a FSE theme called "Cooltech", using the TwentyTwentyTwo theme as a starting point.


## Thirdparty plugins used

 - [Lazy blocks] (https://wordpress.org/plugins/lazy-blocks/)
    This project uses the above third party plugin to allow us to call custom PHP-based plugin directly from query loops and Full Site Editing (FSE) templates
 - [Yoast](https://downloads.wordpress.org/plugin/wordpress-seo.latest-stable.zip)
    For its breadcrumb
 - [SVG Support](https://wordpress.org/plugins/svg-support/)
    To upload SVGs to wordpress and display them inline  

## Acnowdgements

 - [Fontello](https://fontello.com/) for the author/date and view icons

