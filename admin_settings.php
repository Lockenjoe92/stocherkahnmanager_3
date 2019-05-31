<?php

include_once "./ressources/ressourcen.php";
session_manager('ist_admin');
$Header = "Admin Einstellungen - " . lade_xml_einstellung('site_name', 'local');

#Generate content
# Page Title
$PageTitle = '<h1>Admineinstellungen</h1>';
$PageTitle = section_builder($PageTitle);

$PageTitle .= section_builder("hsdkjcgdskjcgsk");

$HTML = container_builder($PageTitle, 'admin_settings_page_title');

# Output site
echo site_header($Header);
echo site_body($HTML);

?>