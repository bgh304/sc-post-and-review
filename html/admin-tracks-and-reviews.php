<?php
class Admin_Tracks_And_Reviews {

    // Renders page for sc-post-and-review-tracks-and-reviews.php
    // Takes tracks and reviews from database as it's parameters
    static function admin_list_tracks_and_reviews($tracks, $reviews) {
        $render = <<<HTML
            <div class="admin-tracks-and-reviews-top-container">
                <div class="admin-tracks-and-reviews-sub-containers">
                    <h2>Tracks</h2>
                    $tracks
                </div>
                <div class="admin-tracks-and-reviews-sub-containers">
                    <h2>Reviews</h2>
                    $reviews
                </div>
        HTML;

        return $render;
    }
}