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
    $HTML .= section_builder('<h5>Lokalisation</h5>');
    $HTML .= section_builder(website_item_info_table_generator($Item));

    # Form depending on type
    $ItemMeta = lade_seiteninhalt($Item);
    $BausteinMeta = lade_baustein($ItemMeta['id_baustein']);
    $HTML .= section_builder('<h5>Inhaltselement</h5>');
    if ($BausteinMeta['typ'] == 'row_container'){
        $HTML .= generate_row_item_change_form($Item);
    }

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

    $TableRowContent = table_header_builder('Subseite:');
    $TableRowContent .= table_data_builder($SeiteMeta['menue_text']);
    $TableRows = table_row_builder($TableRowContent);
    $TableRowContent = table_header_builder('Baustein:');
    $TableRowContent .= table_data_builder($BausteinMeta['name']);
    $TableRows .= table_row_builder($TableRowContent);
    $TableRowContent = table_header_builder('Element:');
    $TableRowContent .= table_data_builder($ItemMeta['ueberschrift']);
    $TableRows .= table_row_builder($TableRowContent);

    $Table = table_builder($TableRows);
    return $Table;
}

function generate_row_item_change_form($Item){

    $ItemMeta = lade_seiteninhalt($Item);

    $TableRows = table_form_string_item('Überschrift', 'item_title', $ItemMeta['ueberschrift'], '');
    $TableRows .= table_form_html_area_item('Inhalt HTML', 'item_html', $ItemMeta['html_content'], '');
    $TableRows .= table_form_string_item('Icon', 'item_icon', $ItemMeta['icon'], '');
    $TableRowContent = table_header_builder(form_button_builder('action_edit_site_item', 'Bearbeiten', 'action', 'edit', ''));
    $TableRowContent .= table_data_builder(button_link_creator('Zurück', './admin_edit_startpage.php', 'arrow_back', ''));
    $TableRows .= table_row_builder($TableRowContent);
    $Table = table_builder($TableRows);
    $Form = form_builder($Table, '#', 'post', 'item_change_form');
    $Section = section_builder($Form);

    return $Section;

}