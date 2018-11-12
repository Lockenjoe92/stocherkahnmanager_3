<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 15.06.18
 * Time: 16:18
 */

function lade_user_id(){

    return 1;

}

function add_new_user($Vorname, $Nachname, $Strasse, $Hausnummer, $PLZ, $Stadt, $Mail, $PSWD, $Rollen){

    $link = connect_db();

    $PSWD_hashed = password_hash($PSWD, 'PASSWORD_DEFAULT');

    if (!($stmt = $link->prepare("INSERT INTO users VALUES (?,?)"))) {
        $Antwort['erfolg'] = false;
        $Antwort['meldung'] = "Prepare failed: (" . $link->errno . ") " . $link->error;
    }
    if (!$stmt->bind_param("ss", $Mail, $PSWD_hashed)) {
        $Antwort['erfolg'] = false;
        $Antwort['meldung'] =  "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if (!$stmt->execute()) {
        $Antwort['erfolg'] = false;
        $Antwort['meldung'] =  "Execute failed: (" . $stmt->errno . ") " . $stmt->error;

    } else {

        if (!($stmt = $link->prepare("SELECT id FROM users WHERE mail = ?"))) {
            $Antwort['erfolg'] = false;
            $Antwort['meldung'] = "Prepare failed: (" . $link->errno . ") " . $link->error;
        }
        if (!$stmt->bind_param("s", $Mail)) {
            $Antwort['erfolg'] = false;
            $Antwort['meldung'] =  "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            $Antwort['erfolg'] = false;
            $Antwort['meldung'] = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $res = $stmt->get_result();
        $Ergebnis = mysqli_fetch_assoc($res);

        #Weitere Userinfos hinzufügen
        add_user_meta($Ergebnis['id'], 'vorname', $Vorname);
        add_user_meta($Ergebnis['id'], 'nachname', $Nachname);
        add_user_meta($Ergebnis['id'], 'strasse', $Strasse);
        add_user_meta($Ergebnis['id'], 'hausnummer', $Hausnummer);
        add_user_meta($Ergebnis['id'], 'plz', $PLZ);
        add_user_meta($Ergebnis['id'], 'stadt', $Stadt);

        #Rollen eingeben
        foreach($Rollen as $Rolle => $Wert){
            add_user_meta($Ergebnis['id'], $Rolle, $Wert);
        }

        $Antwort['erfolg'] = True;
        $Antwort['meldung'] = "Dein Useraccount wurde erfolgreich angelegt! Du erh&auml;ltst noch eine eMail, die den Vorgang best&auml;tigt!<br>Du kannst dich jetzt <a href='./login.php'>hier einloggen</a>!:)";
    }


    return $Antwort;
}

function add_user_meta($UserID, $Key, $Value){

    $link = connect_db();

    if (!($stmt = $link->prepare("INSERT INTO user_meta VALUES ?,?,?,?"))) {
        $Antwort['erfolg'] = false;
        $Antwort['meldung'] = "Prepare failed: (" . $link->errno . ") " . $link->error;
    }
    if (!$stmt->bind_param("isss", $UserID, $Key, $Value, timestamp())) {
        $Antwort['erfolg'] = false;
        $Antwort['meldung'] =  "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if (!$stmt->execute()) {
        $Antwort['erfolg'] = false;
        $Antwort['meldung'] = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } else {
        $Antwort['erfolg'] = true;
    }

}
?>