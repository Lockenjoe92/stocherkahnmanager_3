<?php

include_once "./ressources/ressourcen.php";
session_manager('ist_admin');
$Header = "Admin Einstellungen - " . lade_xml_einstellung('site_name', 'local');

#Generate content
# Page Title
$PageTitle = '<h1>Admineinstellungen</h1>';
$HTML = section_builder($PageTitle, 'admin_settings_page_title');

# Settings List
$FormItems = form_switch_item('Deaktiviert', 'Aktiviert', 'true', true);    #Website aktivieren

# Wrap up everything
$FormHTML = form_builder($FormItems, './admin_settings.php', 'admin_settings_form');
$HTML .= section_builder($FormHTML, 'admin_settings_form_section');
$HTML = container_builder($HTML, 'admin_settings_main_container');

# Output site
echo site_header($Header);
echo site_body($HTML);

?>