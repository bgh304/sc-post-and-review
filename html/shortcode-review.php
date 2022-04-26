<?php
class Shortcode_Review {

    // Returns one review instance in sc-post-and-review-shortcode
    static function get_shortcode_review( $score_img, $review, $reviewer, $css_data ) {

        $render = <<<HTML
            <div class="shortcode-review">
                <p>$score_img</p>
                <p class="shortcode-review-review">$review</p>
                <p class="">$reviewer</p>
            </div>
            <div class="shortcode-review-hr">
                <hr />
            </div>
        HTML;

        return $render;
    }
}
?>