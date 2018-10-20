<?php

function login_formular(){

    $HTML = "<div class='container'>";
    $HTML .= "<div class='row center'>";
    $HTML .= "<form action='#' method='post' class='col s12'>";

    $HTML .= "<div class='row'>";
    $HTML .= "<div class='input-field col s6'>";
    $HTML .= "<input id='login_mail' type='email' name='mail'>";
    $HTML .= "<label for='login_mail'>Mail</label>";
    $HTML .= "</div>";
    $HTML .= "</div>";

    $HTML .= "<div class='row'>";
    $HTML .= "<div class='input-field col s6'>";
    $HTML .= "<input id='login_pswd' type='password' name='pass'>";
    $HTML .= "<label for='login_pswd'>Passwort</label>";
    $HTML .= "</div>";
    $HTML .= "</div>";

    $HTML .= "<div class='row'>";
    $HTML .= "<div class='input-field col s6'>";
    $HTML .= "<input type='submit' name='submit'>";
    $HTML .= "</div>";
    $HTML .= "</div>";

    $HTML .= "</form>";
    $HTML .= "</div>";
    $HTML .= "</div>";

    return $HTML;
}

?>