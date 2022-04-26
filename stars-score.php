<?php

function stars_score( $score, $size ) {
    $star_path = plugin_dir_url( __FILE__ ) . 'assets/star.png';
    $starempty_path = plugin_dir_url( __FILE__ ) . 'assets/starempty.png';

    // Renders scores as stars
    for ( $i = 0; $i < $score; $i++ ) {
        $stars_score .= '<img style="margin-right: 5px; width: ' . $size . 'px; height: ' . $size . 'px;" src="' . $star_path . '"/>';
    }

    // Renders (possibly) remaining stars as empty stars
    for ( $i = 0; $i < 5 - $score; $i++ ) {
        $stars_score .= '<img style="margin-right: 5px; width: ' . $size . 'px; height: ' . $size . 'px;" src="' . $starempty_path . '"/>';
    }

    return $stars_score;
}