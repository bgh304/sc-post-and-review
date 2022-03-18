<?php
$path = preg_replace('/wp-content.*$/','',__DIR__);

require_once($path . "wp-load.php");

$trackid = $_GET['id'];
global $db_version; //TODO: tarvitseeko tätä?

global $wpdb;

$trackresult = $wpdb->get_results("SELECT * FROM wp_sctracks WHERE id='$trackid'");

foreach ($trackresult as $print)
{
    $artist = $print->artistname;
    $track = $print->trackname;
}

echo <<<HTML
    <body style="background-color: #E5E7E9; font-family: arial;">
    <style>
        .button {
            width: 35%;
            height: 45px;
            border: none;
            font-size: 20px;
            font-weight: bold;
            color: white;
            border-radius: 3px;
        }
        .yesbtn {
            background-color: #E53B3B;
        }
        .nobtn {
            background-color: #578AB3;
        }
    </style>
    <div style="padding: 10px; width: 500px;">
        <h2>Delete "$artist - $track"?</h2>
        <form method="post">
            <input type="submit" class="button yesbtn" name="yes" value="YES">
            <input type="submit" class="button nobtn" name="no" value="NO">
        </form>
    </div>
    </body>
HTML;

if (isset($_POST['yes']))
{
    $wpdb->delete($wpdb->prefix . 'screviews', array('trackId' => $trackid), $format=NULL);
    $wpdb->delete($wpdb->prefix . 'sctracks', array('id' => $trackid), $format=NULL);

    wp_redirect(esc_url(add_query_arg('', '', 'http://localhost/plugarit/wp-admin/admin.php?page=sc-post-and-review-admin-menu')), 301); //TODO: muuta path
}

if (isset($_POST['no']))
{
    wp_redirect(esc_url(add_query_arg('', '', 'http://localhost/plugarit/wp-admin/admin.php?page=sc-post-and-review-admin-menu')), 301); //TODO: muuta path
}