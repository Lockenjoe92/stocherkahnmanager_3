<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 22.11.18
 * Time: 13:00
 */

function ds_anlegen_formular($Parser){

    $HTML = $Parser['meldung'];
    $HTML .= "<form action='datenschutzerklaerungen.php' method='post'>";
    $HTML .= "Version: <input type='text' name='version_large' id='version_large' placeholder='".$_POST['version_large']."'>";
    $HTML .= "Erkl&auml;rung: <input type='text' name='erklaerung_large' id='erklaerung_large' placeholder='".$_POST['erklaerung_large']."'>";
    $HTML .= "Inhalt: <input type='text' name='inhalt_large' id='inhalt_large' placeholder='".$_POST['inhalt_large']."'>";
    $HTML .= "<input type='submit' name='action_large'>";
    $HTML .= "</form>";

    return $HTML;

}

function ds_anlegen_parser(){

    $link = connect_db();
    $CurrentUser = lade_user_id();
    $UserMeta = lade_user_meta($CurrentUser);

    if(isset($_POST['action'])){

        ## DAU CHECKS BEFORE LOGIN ATTEMPT ##
        $DAUcounter = 0;
        $DAUerror = "";
        $arg = "large";

        if($UserMeta['ist_wart'] != 'true'){
            $DAUcounter ++;
            $DAUerror .= "Du hast keine Berechtigung f&uuml;r diesen Vorgang!<br>";
        }

        if(empty($_POST['inhalt_'.$arg.''])){
            $DAUcounter ++;
            $DAUerror .= "Gib bitte den Inhalt der Datenschutzerkl&auml;rung an!<br>";
        }

        if(empty($_POST['erklaerung_'.$arg.''])){
            $DAUcounter ++;
            $DAUerror .= "Gib bitte eine Erkl&auml;rung f&uuml;r die User an!<br>";
        }

        if(empty($_POST['version_'.$arg.''])){
            $DAUcounter ++;
            $DAUerror .= "Gib bitte eine Versionsangabe an!<br>";
        } else {

            if (!($stmt = $link->prepare("SELECT id FROM datenschutzerklaerungen WHERE version = ?"))) {
                echo "Prepare failed: (" . $link->errno . ") " . $link->error;
            }

            if (!$stmt->bind_param("s",$_POST['version_'.$arg.''])) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            if (!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            $res = $stmt->get_result();
            $num_results = mysqli_num_rows($res);

            if($num_results > 0){
                $DAUcounter ++;
                $DAUerror .= "Die von dir eingegebene eMail-Adresse ist bereits mit einem anderen Account verkn&uuml;pft! Versuche es mit einer anderen eMail oder verwende die <a href='./reset_password.php'>Passwort zur&uuml;cksetzen Funktion</a>.<br>";
            }

        }

        ## DAU auswerten
        if ($DAUcounter > 0){
            $Antwort['meldung'] = $DAUerror;
            return $Antwort;

        } else {
            $Antwort = ds_anlegen($_POST['erklaerung_'.$arg.''], $_POST['version_'.$arg.''], $_POST['inhalt_'.$arg.''], $CurrentUser);
            return $Antwort;
        }

    } else{return null;}

}

function ds_anlegen($Erklaerung, $Version, $Inhalt, $User){

    $link = connect_db();
    $timestamp = timestamp();

    if (!($stmt = $link->prepare("INSERT INTO datenschutzerklaerungen (version, erklaerung, inhalt, ersteller, create_time) VALUES (?,?,?,?,?)"))) {
        echo "Prepare failed: (" . $link->errno . ") " . $link->error;
        return $Antwort['erfolg'] = false;
    }

    if (!$stmt->bind_param("sssis",$Version, $Erklaerung, $Inhalt, $User, $timestamp)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        return $Antwort['erfolg'] = false;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        return $Antwort['erfolg'] = false;
    } else {
        $Antwort['meldung'] = 'Anlegen erfolgreich!';
        $Antwort['erfolg'] = true;
        return $Antwort;
    }

}

?>