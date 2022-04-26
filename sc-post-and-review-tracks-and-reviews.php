<?php

require_once 'stars-score.php';
require_once 'html/track-wp-admin.php';
require_once 'html/review-wp-admin.php';
require_once 'html/admin-tracks-and-reviews.php';

// Rendering Manage Tracks and Reviews page
function list_tracks_and_reviews() {

    global $wpdb;

    // Fetching tracks from database
    $table_name_tracks = $wpdb->prefix . 'sctracks';
    $track_result = $wpdb->get_results( "SELECT * FROM $table_name_tracks" );
    $render_tracks = array();
    //$edittrack_path = "http://localhost/plugarit/wp-content/plugins/sc-post-and-review/edittrack";
    $edittrack_path = home_url( 'wp-content/plugins/sc-post-and-review/edittrack' );
    //$deletetrack_path = "http://localhost/plugarit/wp-content/plugins/sc-post-and-review/html/delete-track.php";
    $deletetrack_path = home_url( 'wp-content/plugins/sc-post-and-review/html/delete-track.php' );
    $track_object = new Track_WP_Admin();

    foreach ( $track_result as $print ) {
        $id = $print->id;
        $artist = $print->artistname;
        $track = $print->trackname;
        $shortcode = $print->shortcode;
        $description = $print->description;

        $render_tracks[] .= $track_object->get_track_wp_admin( $id, $artist, $track, $shortcode, $description, $edittrack_path, $deletetrack_path );
    }

    $tracks;
    foreach( $render_tracks as $render ) {
        $tracks .= $render;
    }

    // Fetching reviews from database
    $table_name_reviews = $wpdb->prefix . 'screviews';
    $review_result = $wpdb->get_results( "SELECT * FROM $table_name_reviews" );
    $render_reviews = array();
    //$deletereview_path = "http://localhost/plugarit/wp-content/plugins/sc-post-and-review/deletereview";
    $deletereview_path = home_url( 'wp-content/plugins/sc-post-and-review/deletereview' );
    $review_object = new Review_WP_Admin();
    foreach ( $review_result as $print ) {
        $id = $print->id;
        $track_id = $print->trackId;
        $reviewer = $print->reviewer;
        $review = $print->review;
        $score = $print->score;

        $stars_score = stars_score( $score, 15 ); // Second parameter is size of the stars. 37 is max size.

        $render_reviews[] .= $review_object->get_review_wp_admin( $id, $track_id, $stars_score, $review, $reviewer, $editreview_path, $deletereview_path );
    }

    $reviews;
    foreach( $render_reviews as $render ) {
        $reviews .= $render;
    }

    // Rendering the page
    $list_tracks_and_reviews = new Admin_Tracks_And_Reviews();
    echo $list_tracks_and_reviews->admin_list_tracks_and_reviews($tracks, $reviews);
}

function load_stylesheet() {
    wp_enqueue_style( 'pluginStyles', plugins_url( 'css/styles.css', __FILE__ ), '', time() );
}
add_action( 'admin_enqueue_scripts', 'load_stylesheet' );