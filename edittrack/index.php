<?php
$path = preg_replace('/wp-content.*$/','',__DIR__);

require_once($path . "wp-load.php");



$trackid = $_GET['id'];
global $db_version; //TODO: tarvitseeko tätä?

global $wpdb;

$trackresult = $wpdb->get_results("SELECT * FROM wp_sctracks WHERE id='$trackid'");

foreach ($trackresult as $print)
{
    $id = $print->id;
    $artist = $print->artistname;
    $track = $print->trackname;
    $shortcode = $print->shortcode;
    $description = $print->description;
    $iframe = $print->iframe;
}

/*
echo <<<HTML
    <style>
        .button {
            border: none;
            width: 500px;
            height: 100px;
            margin-top: 20px;
            font-size: 15px;
            font-weight: bold;
            font-size: 30px;
        }
        .button:hover {background-color: gray}
        .button:active {background-color: black; color: white; }
    </style>
    <div style="text-align: center; padding-top: 15%;">
        <p style="font-family: arial; font-size: 30px;">Thank you for your review <b>$reviewer</b>!</p>
        <button id="back" class="button">GO BACK</button>
        <script>
            function go_back() {
                window.history.back();
            }
            let button = document.getElementById("back");
            button.addEventListener('click', event => {go_back()});
        </script>
    </div>
HTML;
*/

//TODO: stailaa sivu samanlaiseksi kuin thankyou-sivu, muuta nappien värit
echo <<<HTML
    <body style="background-color: #E5E7E9; font-family: arial;">
    <style>
        input {
            width: 270px;
            height: 25px;
            border: none;
            border-radius: 3px;
            margin-bottom: 5px;
        }
        .button {
            width: 20%;
            height: 25px;
            border: none;
            font-weight: bold;
            color: white;
            border-radius: 3px;
        }
        .savebtn {
            background-color: limegreen;
        }
        .cancelbtn {
            background-color: #578AB3;
        }
    </style>
    <div style="padding: 10px; width: 500px;">
        <h2>Edit track "$artist - $track"</h2>
        <form method="post" action="">
            <label for="artist_name">Artist Name</label><br />
            <input type="text" id="artist_name" name="artist_name" value="$artist"><br />
            <label for="track_name">Track Name</label><br />
            <input type="text" id="track_name" name="track_name" value="$track"><br />
            <label for="track_iframe">IFrame Code <i>(leave blank for no change)</i></label><br />
            <input type="text" id="track_iframe" name="track_iframe"><br />
            <label for="shortcode_param">Shortcode Parameter</label><br />
            <input type="text" id="shortcode_param" name="shortcode_param" value="$shortcode"><br />
            <label for="description">Track Description</label><br />
            <input type="text" id="description" name="description" value="$description" style="margin-bottom: 10px;"><br />
            <input type="submit" name="savetrack" class="button savebtn" value="SAVE">
            <input type="submit" name="cancel" class="button cancelbtn" value="CANCEL">
        </form>
    </div>
    </body>
HTML;

if (isset($_POST['savetrack']))
{
    if ($_POST['track_iframe'] == NULL)
    {
        $data = array(
            'artistname' => sanitize_text_field($_POST['artist_name']),
            'trackname' => sanitize_text_field($_POST['track_name']),
            'shortcode' => sanitize_text_field($_POST['shortcode_param']),
            'description' => sanitize_text_field($_POST['description']),
        );
    } else {
        $data = array(
            'artistname' => sanitize_text_field($_POST['artist_name']),
            'trackname' => sanitize_text_field($_POST['track_name']),
            'shortcode' => sanitize_text_field($_POST['shortcode_param']),
            'description' => sanitize_text_field($_POST['description']),
            'iframe' => $_POST['track_iframe'],
        );
    }

    $wpdb->update($wpdb->prefix . 'sctracks', $data, array('id' => $trackid), $format=NULL);

    wp_redirect(esc_url(add_query_arg('', '', 'http://localhost/plugarit/wp-admin/admin.php?page=sc-post-and-review-admin-menu')), 301); //TODO: muuta path
}

if(isset($_POST['cancel'])) {
    wp_redirect(esc_url(add_query_arg('', '', 'http://localhost/plugarit/wp-admin/admin.php?page=sc-post-and-review-admin-menu')), 301); //TODO: muuta path
}