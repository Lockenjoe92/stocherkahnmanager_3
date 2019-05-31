<?php

include_once "./ressources/ressourcen.php";
session_manager('ist_admin');
$Header = "Admin Einstellungen - " . lade_xml_einstellung('site_name', 'local');
$Settings = ['site_name'];
$HTML = admin_settings_parser($Settings);

#Generate content
# Page Title
$PageTitle = '<h1>Admineinstellungen</h1>';
$HTML .= section_builder($PageTitle);

#Settings Form
$SettingTableItems = table_form_swich_item('TestWert1', 'deaktiviert', 'aktiviert', 'deaktiviert',lade_db_einstellung('testtest'), false);
$SettingTableItems .= table_form_string_item('Website Name', 'site_name', lade_db_einstellung('site_name'), false);

#Complete Settings Form
$SettingTable = table_builder($SettingTableItems);
$SettingTable = section_builder($SettingTable);
$SettingTable .= section_builder(form_button_builder('admin_settings_action', 'Speichern', 'action', 'send'));

$SettingForm = form_builder($SettingTable, './admin_settings.php', 'post');
$HTML .= section_builder($SettingForm);

#Put it all in a container
$HTML = container_builder($HTML, 'admin_settings_page');

# Output site
echo site_header($Header);
echo site_body($HTML);

?>