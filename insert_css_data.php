<?php
namespace ScPostAndReview;

// Functionality for Config plugin appearance page
class Insert_Css_Data {

    function insert_css_data() {
        global $wpdb;

        // Send Review button color
        if ( isset( $_POST['review_button_submit'] ) ) {
            $button_color = $_POST['button_color'];
            if ( substr( $button_color, 0, 1 ) != '#' ) {
                $button_color = '#' . $button_color;
            }

            $table_name_options = $wpdb->prefix . 'options';
            $getting_id = $wpdb->get_results( "SELECT * FROM $table_name_options WHERE option_name='send_review_button_color';" );

            foreach ( $getting_id as $print ) {
                $id = $print->option_id;
            }

            $wpdb->delete( $wpdb->prefix . 'options', array( 'option_id' => $id ), array( '%d' ) );

            $wpdb->insert( $wpdb->prefix . 'options', array(
                'option_name'=>"send_review_button_color",
                'option_value'=>$button_color,
                'autoload'=>"yes",
            ), $format=null );
        }

        // Headings color
        if ( isset( $_POST['headings_color_submit'] ) ) {
            $headings_color = $_POST['headings_color'];
            if ( substr( $headings_color, 0, 1 ) != '#' ) {
                $headings_color = '#' . $headings_color;
            }

            $table_name_options = $wpdb->prefix . 'options';
            $getting_id = $wpdb->get_results( "SELECT * FROM $table_name_options WHERE option_name='headings_color';" );

            foreach ( $getting_id as $print ) {
                $id = $print->option_id;
            }
            
            $wpdb->delete( $wpdb->prefix . 'options', array( 'option_id' => $id ), array( '%d' ) );

            $wpdb->insert( $wpdb->prefix . 'options', array(
                'option_name'=>"headings_color",
                'option_value'=>$headings_color,
                'autoload'=>"yes",
            ), $format=null );
        }

        // Headings font
        if ( isset( $_POST['headings_font_submit'] ) ) {
            $headings_font = $_POST['headings_font'];

            $table_name_options = $wpdb->prefix . 'options';
            $getting_id = $wpdb->get_results( "SELECT * FROM $table_name_options WHERE option_name='headings_font';" );

            foreach ( $getting_id as $print ) {
                $id = $print->option_id;
            }

            $wpdb->delete( $wpdb->prefix . 'options', array( 'option_id' => $id ), array( '%d') );

            $wpdb->insert( $wpdb->prefix . 'options', array(
                'option_name'=>"headings_font",
                'option_value'=>$headings_font,
                'autoload'=>"yes",
            ), $format=null );
        }
    }
}