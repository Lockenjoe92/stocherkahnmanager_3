<?php

function login_formular(){

    $HTML = "<form action='#' method='post'>";
    $HTML .= "<input type='email' name='mail'>";
    $HTML .= "<input type='password' name='pass'>";
    $HTML .= "<input type='submit' name='submit'>";
    $HTML .= "</form>";

    return $HTML;
}

?>