<?php

// Returns one track & review instance in sc-post-and-review-shortcode
class Shortcode_Track {
    static function get_shortcode_track( $artist, $track, $iframe, $description, $render_review, $css_data ) {
        
        // Wrapping Soundcloud URL in Iframe
        function create_iframe($iframe) {
            return '<iframe width="100%" height="300" scrolling="no" frameborder="no" allow="autoplay" src="' . $iframe . '"></iframe>';
        }
        
        $iframe = create_iframe($iframe);

        // Getting appearance config data
        $button_color = $css_data[0];
        $headings_color = $css_data[1];
        $headings_font = $css_data[2];

        $render = <<<HTML
                <div class="shortcode-track">
                    <h1 class="headings">$artist - $track</h1>
                    $iframe
                    <div>
                        <h4 class="headings">Description</h4>
                        <p class="">$description</p>
                        <h4 class="headings">Reviews</h4>
                        <div class="shortcode-track-review">
                        $render_review
                        </div>
                        <h4 class="headings">Give review</h4>
                        <div>
        HTML;
        // Inserting the appearance config data to CSS
        $render .=
                '<style>
                    .headings {font-family: ' . $headings_font . ';}
                    .headings {color: ' . $headings_color . ';}
                    .submitbtn:hover {background-color: gray;}
                    .submitbtn:active {background-color: black; color: white;}
                    .submitbtn {background-color: ' . $button_color . ';}
                </style>';
        $render .= <<<HTML
                    <form role="form" id="reviewform" autocomplete="off" method="post" class="shortcode-track-form">
                        <label for="score">Score:</label>
                        <input type="number" class="shortcode-track-review-score" id="score" name="score" min="1" max="5"><br /><br />
                        <label for="review">Review:</label>
                        <textarea id="review" name="review" rows="8" cols="50" class="shortcode-track-review-review"></textarea><br /><br /><br /><br /><br />
                        <label for="reviewername">Your Name:</label>
                        <input type="text" id="reviewername" name="reviewername"><br /><br />
                        <input type="submit" value="SEND REVIEW" name="submitbtn" class="submitbtn">
                    </form>
                </div>
            </div>
        </div>
        HTML;

        return $render;
    }
}
?>