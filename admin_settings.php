<?php

include_once "./ressources/ressourcen.php";
session_manager('admin');

$HTML = '<h1>Hello World!</h1>';

#Create Page Sections
$HTML = section_builder($HTML, 'admin_settings_page_title');

#Put it all into a container
$HTML = container_builder($HTML, 'admin_settings_main_container');

echo $HTML;

?>