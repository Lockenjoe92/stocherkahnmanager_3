<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 13.06.18
 * Time: 15:24
 */

function startseite_inhalt_home(){

    $link = connect_db();
    $Tab = $_GET['tab'];
    if (!isset($Tab)){$Tab='index';}

    #Lade alle Websiteteile
    if (!($stmt = $link->prepare("SELECT * FROM homepage_bausteine WHERE ort = ? AND storno_user = '0' ORDER BY rang ASC"))) {
        echo "Prepare failed: (" . $link->errno . ") " . $link->error;
    }

    if (!$stmt->bind_param("s",$Tab)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    $res = $stmt->get_result();
    $Anzahl = mysqli_num_rows($res);

    #Iteriere über die Seiteninhalte
    $HTML = '';
    if($Anzahl == 0){
        $HTML .= container_builder(section_builder('<h2>Hier entsteht eine neue Seite!</h2>'));
    } elseif($Anzahl > 0) {
        $i = 1;
        while ($i <= $Anzahl){
            # Lade Informationen
            $Ergebnis = mysqli_fetch_assoc($res);
            $HTML .= generiere_startseite_content($Ergebnis);
            $i++;
        }
    }

    return $HTML;
}

function generiere_startseite_content($Baustein){

    $HTML = '';

    #Unterscheidung je nach Typ:
    if($Baustein['typ'] == 'parallax_mit_text'){
        $HTML .= parallax_mit_text_generieren($Baustein['id']);
    } elseif($Baustein['typ'] == 'row_container'){
        $HTML .= row_container_generieren($Baustein['id']);
    }

    return $HTML;
}

function parallax_mit_text_generieren($BausteinID){

    $link = connect_db();

    #Lade den content
    $Anfrage = "SELECT * FROM homepage_content WHERE id_baustein = '".$BausteinID."' AND storno_user = '0'";
    $Abfrage = mysqli_query($link, $Anfrage);
    $Anzahl = mysqli_num_rows($Abfrage);

    #Debug
    if ($Anzahl == 0){
        $Content = 'Kein Inhalt auffindbar!';
    } else {

        # Daten laden
        $Ergebnis = mysqli_fetch_assoc($Abfrage);

        # Content generieren
        $Ueberschrift = '<br><br><h1 class="header center '.$Ergebnis['ueberschrift_farbe'].'">' . html_entity_decode($Ergebnis['ueberschrift'],ENT_QUOTES | ENT_IGNORE, "UTF-8") . '</h1>';

        if ($Ergebnis['zweite_ueberschrift'] != '') {
            $Ueberschrift2 = '<div class="row center"><h5 class="header col s12 '.$Ergebnis['zweite_ueberschrift_farbe'].'">' . html_entity_decode($Ergebnis['zweite_ueberschrift'], ENT_QUOTES | ENT_IGNORE, "UTF-8") . '</h5></div>';
        } else {
            $Ueberschrift2 = '';
        }

        if ($Ergebnis['html_content'] != '') {
            $HTML = '<div class="row center">' . html_entity_decode($Ergebnis['html_content'], ENT_QUOTES | ENT_IGNORE, "UTF-8") . '</div><br><br>';
        } else {
            $HTML = '';
        }

        $Content = ($Ueberschrift . $Ueberschrift2 . $HTML);
        $ContainerContent = container_builder($Content);
        $SectionContainerContent = section_builder($ContainerContent, '', 'no-pad-bot');

        #Bild
        $BildHTML = '<img src="' . $Ergebnis['uri_bild'] . '" alt="startseite background img">';
        $Bild = parallax_content_builder($BildHTML, '', '');

        $Content = parallax_container(($SectionContainerContent . $Bild), 'index-banner', '');

    }

    return $Content;
}

function row_container_generieren($BausteinID){

    $link = connect_db();

    #Lade den content
    $Anfrage = "SELECT * FROM homepage_content WHERE id_baustein = '".$BausteinID."' AND storno_user = '0' ORDER BY rang ASC";
    $Abfrage = mysqli_query($link, $Anfrage);
    $Anzahl = mysqli_num_rows($Abfrage);

    #Debug
    if ($Anzahl == 0){
        $Content = 'Kein Inhalt auffindbar!';
    } else {

        $RowContent = '<div class="row">';
        $a = 1;
        $BreiteRowTeile = 12/$Anzahl;
        while ($a<=$Anzahl){

            # Daten laden
            $Ergebnis = mysqli_fetch_assoc($Abfrage);
            $RowContent .= '<div class="col s12 m'.$BreiteRowTeile.'"><div class="icon-block"><h2 class="center '.$Ergebnis['icon_farbe'].'"><i class="material-icons">'.$Ergebnis['icon'].'</i></h2><h5 class="center">'.html_entity_decode($Ergebnis['ueberschrift'], ENT_QUOTES | ENT_IGNORE, "UTF-8").'</h5>'.html_entity_decode($Ergebnis['html_content'], ENT_QUOTES | ENT_IGNORE, "UTF-8").'</div></div>';
            $a++;
        }
        $RowContent .= '</div>';

        $RowSection = section_builder($RowContent, '', '');
        $Content = container_builder($RowSection, '', '');

    }

    return $Content;

}

function startseitenelement_anlegen($Ort, $Typ, $Name){

    $link = connect_db();
    $errorcount = 0;
    $errorstr = '';

    #DAU-Check
    if(empty($Ort)){
        $errorcount++;
        $errorstr .= 'Kein Ort f&uuml;r das Object angegeben!<br>';
    }
    if (empty($Typ)){
        $errorcount++;
        $errorstr .= 'Kein Typ f&uuml;r das Object angegeben!<br>';
    }
    if (empty($Name)){
        $errorcount++;
        $errorstr .= 'Kein Name f&uuml;r das Object angegeben!<br>';
    }
    # Check ob Objekt mit gleichem Namen schon existiert
    if($errorcount == 0){
        $Anfrage = 'SELECT id FROM homepage_bausteine WHERE name = "'.$Name.'" AND ort = "'.$Ort.'" AND storno_user = "0"';
        $Abfrage = mysqli_query($link, $Anfrage);
        $Anzahl = mysqli_num_rows($Abfrage);
        if($Anzahl>0){
            $errorcount++;
            $errorstr .= 'Ein Object mit dem gleichen Namen existiert bereits auf dieser Seite!<br>';
        }
    }

    #Catch Errors
    if($errorcount>0){
        $Antwort['erfolg'] = false;
        $Antwort['meldung'] = $errorstr;
    } else {

        #Anzahl Objekte vorher bestimmen
        $Anfrage2 = "SELECT id FROM homepage_bausteine WHERE ort = '".$Ort."' AND storno_user = '0'";
        $Abfrage2 = mysqli_query($link, $Anfrage2);
        $AnzahlBisherigerObjekte = mysqli_num_rows($Abfrage2);

        #Eintragen
        $Rang = $AnzahlBisherigerObjekte + 1;
        $Anfrage3 = "INSERT INTO homepage_bausteine (ort, typ, rang, name, angelegt_am, angelegt_von, storno_user, storno_time) VALUES ('".$Ort."', '".$Typ."', '".$Rang."', '".$Name."', '".timestamp()."', '".lade_user_id()."', '0', '0000-00-00 00:00:00')";
        $Abfrage3 = mysqli_query($link, $Anfrage3);

        #Überprüfen ob es geklappt hat
        if($Abfrage3){
            $Antwort['erfolg'] = true;
        } else {
            $Antwort['erfolg'] = false;
            $Antwort['meldung'] = 'Fehler beim Eintragen des Bausteins:/';
        }
    }

    return $Antwort;
}

function startseiteninhalt_einfuegen($IDbaustein, $titel, $titel2, $html, $uri_bild, $icon){

    $link = connect_db();
    $errorcount = 0;
    $errorstr = '';

    #DAU-Check
    if(empty($IDbaustein)){
        $errorcount++;
        $errorstr .= 'Kein Seitenelement angegeben!<br>';
    }

    # Check ob noch Platz für weiteres Objekt ist
    if($errorcount == 0){

        #Lade Informationen zum Baustein
        $Baustein = lade_seitenelement($IDbaustein);

        #Lade bisherige Inhalte
        $Anfrage = 'SELECT id FROM homepage_content WHERE id_baustein = "'.$IDbaustein.'" AND storno_user = "0"';
        $Abfrage = mysqli_query($link, $Anfrage);
        $Anzahl = mysqli_num_rows($Abfrage);

        if($Baustein['typ'] == 'row_container'){
            if($Anzahl>=lade_xml_einstellung('max_items_row_container', 'global')){
                $errorcount++;
                $errorstr .= 'Du kannst in diesem Element keine weiteren Inhalte hinzuf&uuml;gen!<br>';
            }
        }

        if($Baustein['typ'] == 'parallax_mit_text'){
            if($Anzahl>=1){
                $errorcount++;
                $errorstr .= 'Du kannst diesem Element keine weiteren Inhalte hinzuf&uuml;gen!<br>';
            }
        }

        if($Baustein['typ'] == 'parallax_ohne_text'){
            if($Anzahl>=1){
                $errorcount++;
                $errorstr .= 'Du kannst diesem Element keine weiteren Inhalte hinzuf&uuml;gen!<br>';
            }
        }

    }

    #Catch Errors
    if($errorcount>0){
        $Antwort['erfolg'] = false;
        $Antwort['meldung'] = $errorstr;
    } else {
        #Eintragen
        $Rang = $Anzahl + 1;
        $Anfrage2 = "INSERT INTO homepage_content (id_baustein, rang, ueberschrift, zweite_ueberschrift, html_content, uri_bild, icon, angelegt_am, angelegt_von, storno_user, storno_time) VALUES ('".$IDbaustein."', '".$Rang."', '".htmlentities($titel)."', '".htmlentities($titel2)."', '".htmlentities($html)."', '".$uri_bild."', '".$icon."', '".timestamp()."', '".lade_user_id()."', '0', '0000-00-00 00:00:00')";
        $Abfrage2 = mysqli_query($link, $Anfrage2);

        #Überprüfen ob es geklappt hat
        if($Abfrage2){
            $Antwort['erfolg'] = true;
        } else {
            $Antwort['erfolg'] = false;
            $Antwort['meldung'] = 'Fehler beim Eintragen des Inhalts:/';
        }
    }

    return $Antwort;

}

function startseitenelement_loeschen($IDbaustein){

    $UserID = lade_user_id();
    $Timestamp = timestamp();
    $link = connect_db();

    if (!($stmt = $link->prepare("UPDATE homepage_bausteine SET storno_user = ?, storno_time = ? WHERE id = ?"))) {
        echo "Prepare 1 failed: (" . $link->errno . ") " . $link->error;
    }

    if (!$stmt->bind_param("iss",$UserID, $Timestamp, $IDbaustein)) {
        echo "Binding 1 parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute 1 failed: (" . $stmt->errno . ") " . $stmt->error;
    } else {

        #Delete all Inhalte
        if (!($stmt = $link->prepare("SELECT * FROM homepage_content WHERE id_baustein = ?"))) {
            echo "Prepare 2 failed: (" . $link->errno . ") " . $link->error;
        }

        if (!$stmt->bind_param("s",$IDbaustein)) {
            echo "Binding 2 parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute 2 failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $res = $stmt->get_result();
        $Anzahl = mysqli_num_rows($res);

        for($x=1;$x<=$Anzahl;$x++){
            $Array = mysqli_fetch_assoc($res);
            $IDElement = intval($Array['id']);
            startseiteninhalt_loeschen($IDElement);
        }
    }

}

function startseiteninhalt_loeschen($IDElement){

    $UserID = intval(lade_user_id());
    $Timestamp = timestamp();
    $link = connect_db();

    if (!($stmt = $link->prepare("UPDATE homepage_content SET storno_user = ?, storno_time = ? WHERE id = ?"))) {
        echo "Prepare 3 failed: (" . $link->errno . ") " . $link->error;
    }

    if (!$stmt->bind_param("isi",$UserID, $Timestamp, intval($IDElement))) {
        echo "Binding 3 parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute 3 failed: (" . $stmt->errno . ") " . $stmt->error;
    }

}

function lade_seitenelement($ID){

    $link = connect_db();

    $Anfrage = "SELECT * FROM homepage_bausteine WHERE id = '".$ID."'";
    $Abfrage = mysqli_query($link, $Anfrage);
    $Ergebnis = mysqli_fetch_assoc($Abfrage);

    return $Ergebnis;

}

function lade_seiteninhalt($ID){

    $link = connect_db();

    $Anfrage = "SELECT * FROM homepage_content WHERE id = '".$ID."'";
    $Abfrage = mysqli_query($link, $Anfrage);
    $Ergebnis = mysqli_fetch_assoc($Abfrage);

    return $Ergebnis;

}

function lade_seite($SiteName){

    $link = connect_db();

    $Anfrage = "SELECT * FROM homepage_sites WHERE name = '".$SiteName."'";
    $Abfrage = mysqli_query($link, $Anfrage);
    $Ergebnis = mysqli_fetch_assoc($Abfrage);

    return $Ergebnis;

}

function update_website_content_item($Item, $Column, $Value){

    $link = connect_db();

    if (!($stmt = $link->prepare("UPDATE homepage_content SET ".$Column." = ? WHERE id = ?"))) {
        echo "Prepare failed: (" . $link->errno . ") " . $link->error;
    }

    if (!$stmt->bind_param("si",$Value,$Item)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        return false;
    } else {
        return true;
    }
}
