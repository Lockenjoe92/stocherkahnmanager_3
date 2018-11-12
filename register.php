<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 12.11.18
 * Time: 08:26
 */

# Include all ressources
include_once "./ressources/ressourcen.php";

#Generate Content
$Header = "Registrieren - " . lade_xml_einstellung('site_name', 'local');

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

# Output site
echo site_header($Header);
echo site_body($HTML);


?>