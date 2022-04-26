<?php

require_once 'stars-score.php';
require_once 'css-data.php';
require_once 'html/shortcode-track.php';
require_once 'html/shortcode-review.php';

// Renders the shortcode for user
function sc_post_and_review_function( $attr ) {
    $args = shortcode_atts(array (
        'track' => '',
    ), $attr );

    $output = $args['track'];

    global $wpdb;

    // Fetching track data from database
    $table_name_tracks = $wpdb->prefix . 'sctracks';
    $track_result = $wpdb->get_results( "SELECT * FROM $table_name_tracks WHERE shortcode='$output';" );
    foreach ( $track_result as $print ) {
        $artist = str_replace( "\'", "'", $print->artistname );
        $artist = str_replace( "\\\"", "\"", $artist );
        $track = $print->trackname;
        $track = str_replace( "\'", "'", $print->trackname );
        $track = str_replace( "\\\"", "\"", $track );
        $iframe = $print->iframe;
        $description = $print->description;
        $id = $print->id;

        $iframe = str_replace( "\\", "", $iframe );
    }

    // Fetching appearance config data
    $css_data = new Css_Data();
    $css_data = $css_data->get_css_data();
    
    // Fetching review data from database
    $table_name_reviews = $wpdb->prefix . 'screviews';
    $review_result = $wpdb->get_results( "SELECT * FROM wp_screviews WHERE trackId='$id'" );
    $review_object = new Shortcode_Review();
    if ( $review_result != NULL ) {
        foreach ( $review_result as $print ) {
            $reviewer = $print->reviewer;
            $review = $print->review;
            $score = $print->score;
    
            $score_img = stars_score( $score, 37 ); // Second parameter is size of the stars. 37 is max size.
            
            $render_reviews .= $review_object->get_shortcode_review( $score_img, $review, $reviewer, $css_data );
        }    
    } else {
        $render_reviews = '<i>No reviews yet!</i>';
    }

    //Rendering content
    $render_tracks = new Shortcode_Track();
    $content = $render_tracks->get_shortcode_track( $artist, $track, $iframe, $description, $render_reviews, $css_data );

    if ( isset( $_POST['submitbtn'] ) && ( $_POST['reviewername'] ) != null && ( $_POST['review'] ) != null && ( $_POST['score'] ) != null ) {
        $data = array(
            'reviewer' => sanitize_text_field($_POST['reviewername']),
            'review' => sanitize_text_field($_POST['review']),
            'score' => sanitize_text_field($_POST['score']),
            'trackId' => $id,
        );

        $result = $wpdb->insert( "wp_screviews", $data, $format=null );

        if ( $result == 1 ) {
            wp_redirect( esc_url( add_query_arg( 'reviewer', $data['reviewer'], 'http://localhost/plugarit/wp-content/plugins/sc-post-and-review/thankyou/' ) ), 301 ); //TODO: muuta path
        }

    } elseif ( isset( $_POST['submitbtn'] ) && ( ( $_POST['reviewername'] ) == null || ( $_POST['review'] ) == null || ( $_POST['score'] ) == null ) ) {
        echo "<script>alert('Please give fill all the fields.');</script>";
    }

    return $content;
}

function load_stylesheet_frontend() {
    wp_enqueue_style( 'pluginStyles', plugins_url( 'css/styles.css', __FILE__ ), '', time() );
}
add_action( 'wp_enqueue_scripts', 'load_stylesheet_frontend' );