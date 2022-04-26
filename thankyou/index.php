<?php
$path = preg_replace('/wp-content.*$/','',__DIR__);
require_once($path . "wp-load.php");

$reviewer = $_GET['reviewer'];

echo <<<HTML
    <style>
        .button {
            border: none;
            width: 500px;
            height: 100px;
            margin-top: 20px;
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