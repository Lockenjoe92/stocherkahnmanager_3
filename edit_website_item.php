<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 06.06.19
 * Time: 10:06
 */

include_once "./ressources/ressourcen.php";
session_manager('ist_admin');
$Item = $_GET['item'];

if(intval($Item)>0){

    #Generate content
    # Page Title
    $Header = "Webseite Editieren - " . lade_db_einstellung('site_name');
    $PageTitle = '<h1>Webseiteinhalt bearbeiten</h1>';
    $HTML = section_builder($PageTitle);
    $HTML .= section_builder(website_item_info_table_generator($Item));

    # Output site
    $HTML = container_builder($HTML, 'websiteinhalt_bearbeiten_container');
    echo site_header($Header);
    echo site_body($HTML);

} else {
    header("Location: ./admin_edit_startpage.php");
    die();
}

function website_item_info_table_generator($Item){

    $ItemMeta = lade_seiteninhalt($Item);
    $BausteinMeta = lade_baustein($ItemMeta['id_baustein']);
    $SeiteMeta = lade_seite($BausteinMeta['ort']);

    $TableRows = table_row_builder(table_header_builder('Subseite:') .+ table_data_builder($SeiteMeta['menue_text']));
    $TableRows .= table_row_builder(table_header_builder('Baustein:') .+ table_data_builder($BausteinMeta['name']));
    $TableRows .= table_row_builder(table_header_builder('Element:') .+ table_data_builder($ItemMeta['ueberschrift']));

    $Table = table_builder($TableRows);
    return $Table;
}