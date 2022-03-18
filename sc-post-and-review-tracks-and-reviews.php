<?php

function list_tracks_and_reviews()
{
    $containerOpening = '<div class="wrap" style="width: 40%;">
                            <h2 style="padding-bottom: 10px;">Tracks</h2>';
    $containerClosing = '</div>';

    global $wpdb;
    $path = preg_replace('/wp-content.*$/','',__DIR__);

    $trackresult = $wpdb->get_results("SELECT * FROM wp_sctracks");
    $renderTracks = array();
    $path = preg_replace('/wp-content.*$/','',__DIR__);
    $edittrack_path = "http://localhost/plugarit/wp-content/plugins/sc-post-and-review/edittrack";
    $deletetrack_path = "http://localhost/plugarit/wp-content/plugins/sc-post-and-review/deletetrack";
    foreach ($trackresult as $print)
    {
        $id = $print->id;
        $artist = $print->artistname;
        $track = $print->trackname;
        $shortcode = $print->shortcode;
        $description = $print->description;
        $iframe = $print->iframe;

        $track_info = <<<HTML
            <div class="flex-container">
                <div style="font-weight: bold;">
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
            <div style="margin-top: 10px; margin-bottom: 30px;">
                <form action=$edittrack_path>
                    <input type="hidden" name="id" value=$id />
                    <button class="edit-delete-btn" name="editbtn" style="margin-right: 10px; background-color: #578AB3;">EDIT</button>
                    <button class="edit-delete-btn" style="background-color: #E53B3B;" formaction="$deletetrack_path">DELETE</button>
                </form>
            </div>
        HTML;

        $renderTracks[] .= $track_info;
    }

    $tracks;
    foreach($renderTracks as $render)
    {
        $tracks .= $render;
    }

    echo $containerOpening . $tracks . $containerClosing;
}