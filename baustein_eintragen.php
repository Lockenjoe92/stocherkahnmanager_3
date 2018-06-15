<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 15.06.18
 * Time: 16:21
 */

include_once 'ressources/ressourcen.php';

#Post einlesen
$Post = $_POST;

#Parser
$ErgebnisParser = website_baustein_eintragen_parser($Post);
if($ErgebnisParser['erfolg'] == true){
    echo "passt";
} else {
    echo $ErgebnisParser['meldung'];
}

echo "<form action='#' method='POST'>";

echo "Ort: <input name='ort' type='text' value='".$Post['ort']."'>";
echo "Typ: <input name='typ' type='text' value='".$Post['typ']."'>";
echo "Name: <input name='name' type='text' value='".$Post['name']."'>";

echo "<input name='action' type='submit'>";

echo "</form>";

function website_baustein_eintragen_parser($Post){
    $Action = startseitenelement_anlegen($Post['ort'], $Post['typ'], $Post['name']);
    return $Action;
}

?>

