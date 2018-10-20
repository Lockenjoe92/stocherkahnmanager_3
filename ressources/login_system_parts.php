<?php

function login_formular($Parser){

    $HTML = "<div class='container'>";
    $HTML .= "<div class='row center'>";
    $HTML .= "<form action='#' method='post' class='col s12'>";

    $HTML .= "<div class='row'>";
    $HTML .= "<div class='input-field col s6'>";
    $HTML .= "<input id='login_mail' type='email' name='mail' value='".$Parser['mail']."'>";
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

    if(isset($Parser['meldung'])){
        $HTML .= $Parser['meldung'];
    }

    return $HTML;
}

function login_parser(){

    if(isset($_POST['submit'])){

        ## DAU CHECKS BEFORE LOGIN ATTEMPT ##
        $DAUcounter = 0;
        $DAUerror = "";

        if(empty($_POST['mail'])){
            $DAUcounter ++;
            $DAUerror .= "Du musst eine eMail-Adresse eingeben!<br>";
        }

        if(empty($_POST['pass'])){
            $DAUcounter ++;
            $DAUerror .= "Du musst dein Passwort eingeben!<br>";
        }

        if ($DAUcounter > 0){
            $Antwort['meldung'] = $DAUerror;
            $Antwort['mail'] = $_POST['mail'];
            echo "nay";
            return $Antwort;
        } else {
            echo "yo";
            return $Antwort['meldung'] = "all clear!!";
        }

    } else {
        return null;
    }
}

?>