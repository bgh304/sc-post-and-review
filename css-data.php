<?php
class Css_Data {

    // Fetching appearance config data from database
    static function get_css_data() {
        global $wpdb;
    
        $css_data = array();
        $table_name = $wpdb->prefix . 'options';

        // Button color
        $result = $wpdb->get_results( "SELECT * FROM $table_name WHERE option_name='send_review_button_color';" );
        foreach ( $result as $print ) {
            $button_color = $print->option_value;
        }
        array_push( $css_data, $button_color );

        // Headings color
        $result = $wpdb->get_results( "SELECT * FROM $table_name WHERE option_name='headings_color';" );
        foreach ( $result as $print ) {
            $headings_color = $print->option_value;
        }
        array_push( $css_data, $headings_color );

        // Headings font
        $result = $wpdb->get_results( "SELECT * FROM $table_name WHERE option_name='headings_font';" );
        foreach ( $result as $print ) {
            $headings_font = $print->option_value;
        }
        array_push( $css_data, $headings_font );

        return $css_data;
    }    
}