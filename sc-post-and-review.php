<?php
/**
*Plugin Name: Soundcloud post and review
*Description: Add Soundcloud track to your page, and let users give reviews for it.
*Version:     1.0
*Author:      Antti Salonen
**/

include 'sc-post-and-review-shortcode.php';
include 'sc-post-and-review-tracks-and-reviews.php';

global $db_version;

function db_install() {
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

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql_tracks);

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

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql_reviews);
}
register_activation_hook(__FILE__, 'db_install');

function sc_post_and_review_admin_menu_option()
{
    add_menu_page('Add Soundcloud Track', 'Add SC Track', 'manage_options', 'sc-post-and-review-admin-menu', 'sc_post_and_review_page', '', 200); //TODO: soundcloud-ikoni
}
add_action('admin_menu', 'sc_post_and_review_admin_menu_option');

function sc_post_and_review_page()
{
    $path = preg_replace('/wp-content.*$/','',__DIR__);
    require_once($path.'/wp-load.php');
    if(isset($_POST['submit']))
    {
        global $wpdb;

        $artist_name = $_POST['artist_name'];
        $track_name = $_POST['track_name'];
        $track_iframe = $_POST['track_iframe'];
        $shortcode_param = $_POST['shortcode_param'];
        $description = $_POST['description'];

        print "<b>\"$artist_name - $track_name\"</b> is added to database.";

        $wpdb->insert($wpdb->prefix . 'sctracks', array( //TODO: korjaa bugi jossa ennen heittomerkkiä tulee \
            'artistname'=>$artist_name,
            'trackname'=>$track_name,
            'iframe'=>$track_iframe,
            'shortcode'=>$shortcode_param,
            'description'=>$description,
        ));
    }
    ?>
    <style>
        .flex-container {
            display: flex;
        }
        .flex-container > div {
            padding-right: 20px;
        }
        .edit-delete-btn {
            width: 75px;
            border: none;
            border-radius: 3px;
            font-weight: bold;
            color: white;
        }
    </style>
    <div class="wrap" style="padding-bottom: 20px;">
        <h2>Add Soundcloud track</h2>
        <form method="post" action="">
            <label for="artist_name">Artist Name</label><br />
            <input type="text" id="artist_name" name="artist_name"><br />
            <label for="track_name">Track Name</label><br />
            <input type="text" id="track_name" name="track_name"><br />
            <label for="track_iframe">IFrame Code</label><br />
            <input type="text" id="track_iframe" name="track_iframe"><br />
            <label for="shortcode_param">Shortcode Parameter</label><br />
            <input type="text" id="shortcode_param" name="shortcode_param"><br />
            <label for="description">Track Description</label><br />
            <input type="text" id="description" name="description" style="margin-bottom: 10px;"><br />
            <input type="submit" name="submit" class="button button-primary" value="ADD TRACK" style="font-weight: bold">
        </form>
    </div>

<?php
list_tracks_and_reviews();
?>

    <div class="wrap" style="width: 40%">
        <h2 style="padding-bottom: 10px;">Reviews</h2>
    </div>
    <?php
            global $wpdb;

            $reviewresult = $wpdb->get_results("SELECT * FROM wp_screviews");
            foreach ($reviewresult as $print)
            {
                $id = $print->id;
                $trackid = $print->trackid;
                $reviewer = $print->reviewer;
                $review = $print->review;
                $score = $print->score;

                $renderReviews .= <<<HTML
                    <div class="flex-container">
                        <div style="font-weight: bold;">
                            ID: <br />
                            Track ID: <br />
                            Score: <br />
                            Review: <br />
                            Reviewer: <br />
                        </div>
                        <div>
                            $id <br />
                            $trackid <br />
                            $reviewer <br />
                            $review <br />
                            $score <br />
                        </div>
                    </div>
                HTML;
            }
    ?>
<?php
}
add_shortcode('sc_post_and_review', 'sc_post_and_review_function');