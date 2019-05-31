<?php

include_once "./ressources/ressourcen.php";
session_manager('ist_admin');
$Header = "Admin Einstellungen - " . lade_xml_einstellung('site_name', 'local');

#Generate content
$HTML = '<h1>Hello World!</h1>';
$HTML = section_builder($HTML, 'admin_settings_page_title');
$HTML = container_builder($HTML, 'admin_settings_main_container');

# Output site
echo site_header($Header);
echo site_body($HTML);

?>