<?php

class Track_WP_Admin {

    // Returns one track instance in sc-post-and-review-tracks-and-reviews.php
    static function get_track_wp_admin( $id, $artist, $track, $shortcode, $description, $edittrack_path, $deletetrack_path ) {

        // Fixing strings to correct form.
        $artist = str_replace( "\'", "'", $artist );
        $artist = str_replace( "\\\"", "\"", $artist );
        $track = str_replace( "\'", "'", $track );
        $track = str_replace( "\\\"", "\"", $track );

        $render = <<<HTML
            <div class="admin-track">
                <div class="admin-track-attributes">
                    ID: <br />
                    Artist: <br />
                    Track: <br />
                    Shortcode: <br />
                    Description: <br />
                </div>
                <div>
                    $id <br />
                    $artist <br />
                    $track <br />
                    $shortcode <br />
                    $description <br />
                </div>
            </div>
            <div class="admin-track-btns">
                <form action=$edittrack_path class="admin-track-form">
                    <input type="hidden" name="id" value=$id />
                    <button class="admin-track-edit-btn">EDIT</button>
                    <button formaction="$deletetrack_path" class="admin-track-delete-btn">DELETE</button>
                </form>
            </div>
        HTML;

        return $render;
    }
}
?>