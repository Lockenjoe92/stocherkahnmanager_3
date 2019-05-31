<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 15.06.18
 * Time: 15:04
 */

function lade_xml_einstellung($NameEinstellung, $mode='global'){

    if($mode == 'global'){
        $xml = simplexml_load_file("./ressources/settings.xml");
    } elseif ($mode == 'db'){
        $xml = simplexml_load_file("./ressources/local_db_settings.xml");
    }

    if (false === $xml) {
        // throw new Exception("Cannot load xml source.\n");
        echo "Einstellung ".$NameEinstellung." laden";
        echo " -> Fehler!";
    }
    $Value = $xml->$NameEinstellung;
    $StrValue = (string) $Value;
    $StrValue = ($StrValue);

    return $StrValue;

}

function update_xml_einstellung($NameEinstellung, $WertEinstellung, $mode='global'){

    $WertEinstellung = utf8_encode($WertEinstellung);

    if($mode == 'global'){
        $xml = simplexml_load_file("./ressources/settings.xml");
        $xml->$NameEinstellung = $WertEinstellung;
        $xml->asXML("./ressourcen/settings.xml");
    } elseif ($mode == 'db'){
        $xml = simplexml_load_file("./ressources/local_db_settings.xml");
        $xml->$NameEinstellung = $WertEinstellung;
        $xml->asXML("./ressourcen/local_db_settings.xml");
    }

}

function lade_db_einstellung($NameEinstellung){

    $value = 'true';

    return $value;

}

?>