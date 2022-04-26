<?php
/**
* Plugin Name: Soundcloud post and review
* Plugin URI:  https://github.com/bgh304/wp_sc_plugin
* Description: Add Soundcloud track to your page, and let users give reviews for it.
* Version:     1.2.0
* Author:      Antti Salonen
* Author URI:  https://github.com/bgh304
**/

namespace ScPostAndReview;

require_once 'sc-post-and-review-shortcode.php';
require_once 'sc-post-and-review-tracks-and-reviews.php';
require_once 'insert_css_data.php';
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

global $db_version;

class SC_Post_And_Review {

    public function __construct() {
        register_activation_hook( __FILE__, array( $this ,'db_install' ) );
        add_action('admin_menu', array( $this, 'sc_post_and_review_admin_menu_option' ) );
        add_shortcode( 'sc_post_and_review', 'sc_post_and_review_function' );
        add_action( 'admin_enqueue_scripts', 'load_stylesheet' );
    }

    static function db_install() {
        global $wpdb;

        $table_name_tracks = $wpdb->prefix . 'sctracks';
        $charset_collate = $wpdb->get_charset_collate();
        $sql_tracks = "CREATE TABLE IF NOT EXISTS $table_name_tracks (
                       id int(10) NOT NULL AUTO_INCREMENT,
                       artistname varchar(255) NOT NULL,
                       trackname varchar(255) NOT NULL,
                       iframe text,
                       shortcode text,
                       description text,
                       PRIMARY KEY  (id)
        ) $charset_collate;";

        dbDelta( $sql_tracks );

        $table_name_reviews = $wpdb->prefix . 'screviews';

        $sql_reviews = "CREATE TABLE IF NOT EXISTS $table_name_reviews (
                        id int(10) NOT NULL AUTO_INCREMENT,
                        reviewer varchar(255) NOT NULL,
                        review text,
                        score int(10),
                        trackId int(10),
                        PRIMARY KEY (id),
                        FOREIGN KEY (trackId) REFERENCES $table_name_tracks(id)
        ) $charset_collate;";

        dbDelta( $sql_reviews );

        $table_name_options = $wpdb->prefix . '_options';
        
        $send_review_button_color_exists = "SELECT * FROM wp_options WHERE option_id = 'send_review_button_color';";

    }

    static function sc_post_and_review_admin_menu_option() {
        add_menu_page(
            'Add Soundcloud Track',
            'Add SC Track',
            'manage_options',
            'sc-post-and-review-admin-menu',
            array( __CLASS__, 'sc_post_and_review_page' ),
            plugin_dir_url( __FILE__ ) . 'assets/soundcloudicon.png',
            4,
        );
        add_submenu_page(
            'sc-post-and-review-admin-menu',
            'Manage Tracks and Reviews',
            'Tracks & Reviews',
            'manage_options',
            'tracks-and-reviews',
            array( __CLASS__, 'tracks_and_reviews_sub_menu' ),
        );
        add_submenu_page(
            'sc-post-and-review-admin-menu',
            'Config plugin appearance',
            'Config',
            'manage_options',
            'config-appearance',
            array( __CLASS__, 'config_appearance_menu' ),
        );
    }

    static function tracks_and_reviews_sub_menu() {
        list_tracks_and_reviews();
    }

    static function config_appearance_menu() {
        // Rendering config appearance page
        require_once('html/config-appearance.php');

        $insert_css_data = new Insert_Css_Data();
        $insert_css_data->insert_css_data();
    }

    static function sc_post_and_review_page() {
        // Rendering add track form
        require_once('html/add-track-form.php');

        if ( isset( $_POST['submit'] ) && ( $_POST['artist_name'] ) != null && ( $_POST['track_name'] ) != null && ( $_POST['track_iframe'] ) != null && ( $_POST['shortcode_param'] ) != null ) {
            global $wpdb;

            $artist_name = $_POST['artist_name'];
            $track_name = $_POST['track_name'];
            $track_iframe = $_POST['track_iframe'];
            $shortcode_param = $_POST['shortcode_param'];
            $description = $_POST['description'];

            $wpdb->insert( $wpdb->prefix . 'sctracks', array(
                'artistname'=>$artist_name,
                'trackname'=>$track_name,
                'iframe'=>$track_iframe,
                'shortcode'=>$shortcode_param,
                'description'=>$description,
            ) );

            echo "<b>\"$artist_name - $track_name\"</b> is added to database.";
        } elseif ( isset( $_POST['submit'] ) && ( ( $_POST['artist_name'] ) == null || ( $_POST['track_name'] ) == null || ( $_POST['track_iframe'] ) == null || ( $_POST['shortcode_param'] ) == null ) ) {
            echo "<script>alert('Please give fill all the fields (description can be empty).');</script>";
        }
    }

    static function load_stylesheet() {
        wp_enqueue_style( 'pluginStyles', plugins_url( 'css/styles.css', __FILE__ ), '', time() );
    }
}
new SC_Post_And_Review();