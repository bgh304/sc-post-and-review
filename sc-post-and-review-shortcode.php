<?php

function sc_post_and_review_function($attr)
{
    $args = shortcode_atts(array (
        'shortcode_param' => '',
    ), $attr);

    $output = $args['shortcode_param'];

    global $wpdb;

    $table_name_tracks = $wpdb->prefix . 'sctracks';

    $trackresult = $wpdb->get_results("SELECT * FROM $table_name_tracks WHERE shortcode='$output';");
    foreach ($trackresult as $print)
    {
        $artist = $print->artistname;
        $track = $print->trackname;
        $iframe = $print->iframe;
        $description = $print->description;
        $id = $print->id;

        $iframe = str_replace("\\", "", $iframe);
    }

    $table_name_reviews = $wpdb->prefix . 'screviews';

    function stars_score($score) {

        $stars_score;
        $star_path = plugin_dir_url(__FILE__) . 'assets/star.png';
        $starempty_path = plugin_dir_url(__FILE__) . 'assets/starempty.png';

        for ($i = 0; $i < $score; $i++)
        {
            $stars_score .= '<img style="padding-right: 5px;" src="' . $star_path . '"/>';
        }

        for ($i = 0; $i < 5 - $score; $i++)
        {
            $stars_score .= '<img style="padding-right: 5px;" src="' . $starempty_path . '"/>';
        }

        return $stars_score;
    }

    $reviewresult = $wpdb->get_results("SELECT * FROM wp_screviews WHERE trackId='$id'");
    
    if ($reviewresult != NULL)
    {
        foreach ($reviewresult as $print)
        {
            $reviewer = $print->reviewer;
            $review = $print->review;
            $score = $print->score;
    
            $scoreImg = stars_score($score);
            
            $reviewRender .= <<<HTML
                    <p style="float: center; padding-left: 50px; padding-right: 50px;">$scoreImg</p>
                    <p style="float: center; padding-left: 50px; padding-right: 50px; font-family: 'Times New Roman';">$review</p>
                    <p style="float: center; padding-left: 50px; padding-right: 50px; font-style: italic;">$reviewer</p>
                    <div style="padding-top: 30px; padding-bottom: 30px;">
                        <hr style="width: 50%;">
                    </div>
                HTML;
        }    
    } else {
        $reviewRender = '<i>No reviews yet!</i>';
    }

    //Rendering content
    $form = '<form role="form" id="reviewform" autocomplete="off" method="post">';
    $content = <<<HTML
    <style>
        .button {
            float: right;
            margin-right: 100px;
            border: none;
            padding: 3%;
            font-size: 15px;
            font-weight: bold;
        }
        .button:hover {background-color: gray}
        .button:active {background-color: black; color: white; }
    </style>
    <div style="height: 100%; width: 50%;">
        <h1>$artist - $track</h1>
        $iframe
        <div style="">
                <h4>Description</h4>
                <p>$description</p>
                <h4>Reviews</h4>
                <div style="width: 100%; height: 250px; overflow: auto">
                    $reviewRender
                </div>
                <h4>Give review</h4>
                <div>
                    $form
                        <label for="score" style="padding-left: 50px;">Score:</label>
                        <input type="number" id="score" name="score" min="1" max="5" style="float: right; margin-right: 100px;"><br /><br />
                        <label for="review" style="padding-left: 50px;">Review:</label>
                        <textarea id="review" name="review" rows="8" cols="50" style="float: right; margin-right: 100px;"></textarea><br /><br /><br /><br /><br />
                        <label for="reviewername" style="padding-left: 50px;">Your Name:</label>
                        <input type="text" id="reviewername" name="reviewername" style="float: right; margin-right: 100px; width: 200px;"><br /><br />
                        <input type="submit" value="SEND REVIEW" name="submitbtn" class="button">
                    </form>
                </div>
        </div>
    </div>
    HTML;
    
    if (isset($_POST['submitbtn']) && ($_POST['reviewername']) != null && ($_POST['review']) != null && ($_POST['score']) != null) {
        $data = array(
            'reviewer' => sanitize_text_field($_POST['reviewername']),
            'review' => sanitize_text_field($_POST['review']),
            'score' => sanitize_text_field($_POST['score']),
            'trackId' => $id,
        );

        $result = $wpdb->insert("wp_screviews", $data, $format=NULL);

        if ($result == 1) {
            wp_redirect(esc_url(add_query_arg('reviewer', $data['reviewer'], 'http://localhost/plugarit/wp-content/plugins/sc-post-and-review/thankyou/')), 301); //TODO: muuta path
        }

    } elseif (isset($_POST['submitbtn']) && (($_POST['reviewername']) == null || ($_POST['review']) == null || ($_POST['score']) == null)) {
        echo "<script>alert('Please give fill all the fields.');</script>";
    }

    return $content;
}