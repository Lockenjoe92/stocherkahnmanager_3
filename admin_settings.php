<?php

include_once "./ressources/ressourcen.php";
session_manager('ist_admin');
$Header = "Admin Einstellungen - " . lade_xml_einstellung('site_name', 'local');

#Generate content
# Page Title
$PageTitle = '<h1>Admineinstellungen</h1>';
$HTML = container_builder($PageTitle, 'admin_settings_page_title');

# Settings List
$FormTableItems = table_form_swich_item('Seitenaktivierung', 'Deaktiviert', 'Aktiviert', 'false', true);
$FormTable = table_builder($FormTableItems);
$FormHTML = form_builder($FormTable, './admin_settings.php', 'admin_settings_form');

$HTML .= container_builder($FormHTML, 'admin_settings_form_section');
$ContainerHTML = container_builder($HTML);

# Output site
echo site_header($Header);
echo site_body($HTML);

?>