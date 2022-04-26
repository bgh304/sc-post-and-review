<?php
class Review_WP_Admin {

    // Returns one review instance in sc-post-and-review-tracks-and-reviews.php
    static function get_review_wp_admin( $id, $track_id, $stars_score, $review, $reviewer, $editreview_path, $deletereview_path ) {

        $render = <<<HTML
            <div class="admin-review">
                <div class="admin-review-attributes">
                    ID: <br />
                    Track ID: <br />
                    Score: <br />
                    Review: <br />
                    Reviewer: <br />
                </div>
                <div>
                    $id <br />
                    $track_id <br />
                    $stars_score <br />
                    $review <br />
                    $reviewer <br />
                </div>
            </div>
            <div class="admin-review-btns">
                <form action=$editreview_path>
                    <input type="hidden" name="id" value="$id" />
                    <button formaction="$deletereview_path" class="admin-review-delete-btn">DELETE</button>
                </form>
            </div>
        HTML;

        return $render;
    }
}
?>