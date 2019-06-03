<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 03.06.19
 * Time: 13:59
 */

include_once "./ressources/ressourcen.php";
session_manager('ist_admin');
$link = connect_db();
$Header = "Startseite Editieren - " . lade_db_einstellung('site_name');

#Generate content
# Page Title
$PageTitle = '<h1>Startseite Editieren</h1>';
$HTML .= section_builder($PageTitle);

# Load Subsites
$Anfrage = "SELECT * FROM homepage_sites WHERE delete_user = 0 ORDER BY menue_rang ASC";
$Abfrage = mysqli_query($link, $Anfrage);
$Anzahl = mysqli_num_rows($Abfrage);
$CollapsibleItems = '';

for($x=1;$x<=$Anzahl;$x++){

    $Ergebnis = mysqli_fetch_assoc($Abfrage);
    $CollapsibleItems .= collapsible_item_builder($Ergebnis['menue_text'], 'CONTENT', 'pageview');

}

#Wrap Collapsibles
$CollapsibleList = collapsible_builder($CollapsibleItems);
$HTML .= section_builder($CollapsibleList);
$HTML = container_builder($HTML, 'admin_edit_startpage_container', '');

# Output site
echo site_header($Header);
echo site_body($HTML);

?>