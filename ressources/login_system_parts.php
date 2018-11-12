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
        } else {

             if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                 $DAUcounter ++;
                 $DAUerror .= "Du musst eine echte eMail-Adresse eingeben!<br>";
             }
        }

        if(empty($_POST['pass'])){
            $DAUcounter ++;
            $DAUerror .= "Du musst dein Passwort eingeben!<br>";
        }

        if ($DAUcounter > 0){
            $Antwort['meldung'] = $DAUerror;
            $Antwort['mail'] = $_POST['mail'];
            return $Antwort;

        } else {

            $link = connect_db();
            if (!($stmt = $link->prepare("SELECT id, secret FROM users WHERE mail = ?"))) {
                echo "Prepare failed: (" . $link->errno . ") " . $link->error;
            }

            if (!$stmt->bind_param("s",$_POST['pass'])) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            if (!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            $res = $stmt->get_result();
            $num_user = mysqli_num_rows($res);

            if ($num_user != 1){
                $Antwort['meldung'] = "Userkonto existiert nicht!";
            } else {

                $Vals = $res->fetch_assoc();
                $StoredSecret = $Vals['secret'];

                if (password_verify($_POST['pass'], $StoredSecret)){
                    $Antwort['meldung'] = "Einloggen erfolgreich!!";
                } else {
                    $Antwort['meldung'] = "Passwort ung&uuml;ltig!";
                }

            }


            return $Antwort;
        }

    } else {
        return null;
    }
}

function register_formular($Parser){

    $HTML = "<form action='register.php' method='post'>";
    $HTML .= "Vorname: <input type='text' name='vorname_large' id='vorname_large'>";
    $HTML .= "Nachname: <input type='text' name='nachname_large' id='nachname_large'>";
    $HTML .= "Stra&szlig;e: <input type='text' name='strasse_large' id='strasse_large'> Hausnummer: <input type='text' name='hausnummer_large' id='hausnummer_large'>";
    $HTML .= "Postleitzahl: <input type='text' name='plz_large' id='plz_large'> Stadt: <input type='text' name='stadt_large' id='stadt_large'>";
    $HTML .= "EMail: <input type='email' name='mail_large' id='mail_large'>";
    $HTML .= "Passwort: <input type='password' name='password_large' id='password_large'>";
    $HTML .= "Passwort wiederholen: <input type='password' name='password_verify_large' id='password_verify_large'>";
    $HTML .= "<input type='submit' name='action_large'>";
    $HTML .= "</form>";

    return $HTML;

}

function register_parser(){

    return null;
}

?>