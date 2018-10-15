<?php

function login_formular(){

    $HTML = "<div class='row'>";
    $HTML .= "<form action='#' method='post' class='col s12'>";

    $HTML .= "<div class='row'>";
    $HTML .= "<div class='input-field col s6'>";
    $HTML .= "<input type='email' name='mail'>";
    $HTML .= "</div>";
    $HTML .= "</div>";

    $HTML .= "<div class='row'>";
    $HTML .= "<div class='input-field col s6'>";
    $HTML .= "<input type='password' name='pass'>";
    $HTML .= "</div>";
    $HTML .= "</div>";

    $HTML .= "<div class='row'>";
    $HTML .= "<div class='input-field col s6'>";
    $HTML .= "<input type='submit' name='submit'>";
    $HTML .= "</div>";
    $HTML .= "</div>";

    $HTML .= "</form>";
    $HTML .= "</div>";

    return $HTML;
}

?>