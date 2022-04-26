<?php

function give_stars_score(){
    $star_path = plugin_dir_url( __FILE__ ) . 'assets/star.png';
    $starempty_path = plugin_dir_url( __FILE__ ) . 'assets/starempty.png';
    $rate_empty_path = plugin_dir_url( __FILE__ ) . 'assets/rateempty.png';

    $score;

    $stars_score =
                '<img src="' . $starempty_path . '" id="1" onmouseover="starOn(1)" onmouseout="starOff(1)" onClick="starSet(1)">
                <img src="' . $starempty_path . '" id="2" onmouseover="starOn(2)" onmouseout="starOff(2)" onClick="starSet(2)">
                <img src="' . $starempty_path . '" id="3" onmouseover="starOn(3)" onmouseout="starOff(3)" onClick="starSet(3)">
                <img src="' . $starempty_path . '" id="4" onmouseover="starOn(4)" onmouseout="starOff(4)" onClick="starSet(4)">
                <img src="' . $starempty_path . '" id="5" onmouseover="starOn(5)" onmouseout="starOff(5)" onClick="starSet(5)">
                <script>
                    function starSet(starId) {
                        let id = document.getElementById(starId).id;
                    }

                    function starOn(starId) {
                        let id = document.getElementById(starId).id;

                            if (id == 1) {
                                document.getElementById(1).src = "' . $star_path . '";
                            } else if (id == 2) {
                                document.getElementById(1).src = "' . $star_path . '";
                                document.getElementById(2).src = "' . $star_path . '";
                            } else if (id == 3) {
                                document.getElementById(1).src = "' . $star_path . '";
                                document.getElementById(2).src = "' . $star_path . '";
                                document.getElementById(3).src = "' . $star_path . '";
                            } else if (id == 4) {
                                document.getElementById(1).src = "' . $star_path . '";
                                document.getElementById(2).src = "' . $star_path . '";
                                document.getElementById(3).src = "' . $star_path . '";
                                document.getElementById(4).src = "' . $star_path . '";
                            } else if (id == 5) {
                                document.getElementById(1).src = "' . $star_path . '";
                                document.getElementById(2).src = "' . $star_path . '";
                                document.getElementById(3).src = "' . $star_path . '";
                                document.getElementById(4).src = "' . $star_path . '";
                                document.getElementById(5).src = "' . $star_path . '";
                            }
                    }

                    function starOff(starId) {
                        let id = document.getElementById(starId).id;

                        if (id == 1) {
                            document.getElementById(1).src = "' . $starempty_path . '";
                        } else if (id == 2) {
                            document.getElementById(1).src = "' . $starempty_path . '";
                            document.getElementById(2).src = "' . $starempty_path . '";
                        } else if (id == 3) {
                            document.getElementById(1).src = "' . $starempty_path . '";
                            document.getElementById(2).src = "' . $starempty_path . '";
                            document.getElementById(3).src = "' . $starempty_path . '";
                        } else if (id == 4) {
                            document.getElementById(1).src = "' . $starempty_path . '";
                            document.getElementById(2).src = "' . $starempty_path . '";
                            document.getElementById(3).src = "' . $starempty_path . '";
                            document.getElementById(4).src = "' . $starempty_path . '";

                        } else if (id == 5) {
                            document.getElementById(1).src = "' . $starempty_path . '";
                            document.getElementById(2).src = "' . $starempty_path . '";
                            document.getElementById(3).src = "' . $starempty_path . '";
                            document.getElementById(4).src = "' . $starempty_path . '";
                            document.getElementById(5).src = "' . $starempty_path . '";
                        }
                    }
                </script>
                ';

    return $stars_score;
}

/*
let star1 = false;
let starHelp1 = false;

function myFunction() {

  if (starHelp1 === false) {
    star1 = true;
    starHelp1 = star1;
    document.getElementById("text").innerHTML = "ON";
  } else if (starHelp1 === true) {
    star1 = false;
    starHelp1 = star1;
    document.getElementById("text").innerHTML = "OFF";
  }
}

                        let star1 = false;
                        let star2 = false;
                        let star3 = false;
                        let star4 = false;
                        let star5 = false;

                        let starHelp1 = false;
                        let starHelp2 = false;
                        let starHelp3 = false;
                        let starHelp4 = false;
                        let starHelp5 = false;



*/