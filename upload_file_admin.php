<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 03.06.19
 * Time: 13:59
 */

include_once "./ressources/ressourcen.php";
session_manager();
$Header = "Datei hochladen - " . lade_db_einstellung('site_name');

#Generate content
# Page Title
$PageTitle = '<h1>Datei hochladen</h1>';
$HTML = section_builder($PageTitle);
$HTML .= generate_datei_upload_form();
$Container = container_builder($HTML);

# Output site
echo site_header($Header);
echo site_body($Container);

function generate_datei_upload_form(){

    $TableRows = table_form_file_upload_builder('Datei auswählen', 'file_to_upload');
    $TableRows .= table_form_file_upload_directory_chooser_builder('Ort zum hochladen wählen', 'upload_dir');

    $TableRowContent = table_data_builder(button_link_creator('Zurück', './administration.php', 'arrow_back', ''));
    $TableRowContent .= table_header_builder(form_button_builder('action_upload_file', 'Hochladen', 'action', 'file_upload', ''));
    $TableRows .= table_row_builder($TableRowContent);
    $Table = table_builder($TableRows);
    $Form = form_builder($Table, '#', 'post', 'file_uploader', 'multipart/form-data');
    $Section = section_builder($Form);

    return $Section;
}

?>