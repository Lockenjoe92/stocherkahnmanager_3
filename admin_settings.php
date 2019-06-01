<?php

include_once "./ressources/ressourcen.php";
session_manager('ist_admin');
$Header = "Admin Einstellungen - " . lade_db_einstellung('site_name');
$Settings = ['site_name', 'site_footer_name', 'earliest_begin', 'latest_begin', 'site_menue_color',
    'site_footer_color', 'site_buttons_color', 'site_error_buttons_color', 'display_big_footer',
    'big_footer_left_column_html', 'big_footer_right_column_html'];
admin_settings_parser($Settings);

#Generate content
# Page Title
$PageTitle = '<h1>Admineinstellungen</h1>';
$HTML .= section_builder($PageTitle);

#Settings Form
$SettingTableItems = table_form_string_item('Website Name', 'site_name', lade_db_einstellung('site_name'), false);
$SettingTableItems .= table_form_string_item('Website Footer Name', 'site_footer_name', lade_db_einstellung('site_footer_name'), false);
$SettingTableItems .= table_form_swich_item('Website Big Footer', 'display_big_footer', 'deaktiviert', 'aktiviert', lade_db_einstellung('display_big_footer'), false);
$SettingTableItems .= table_form_html_area_item('Big Footer Left Column', 'big_footer_left_column_html', lade_db_einstellung('big_footer_left_column_html'), false);
$SettingTableItems .= table_form_html_area_item('Big Footer Right Column', 'big_footer_right_column_html', lade_db_einstellung('big_footer_right_column_html'), false);

$SettingTableItems .= table_form_select_item('Fr&uuml;hester Verleihbeginn', 'earliest_begin', 5, 23,intval(lade_db_einstellung('earliest_begin')), '', '', '');
$SettingTableItems .= table_form_select_item('Sp&auml;tester Verleihbeginn', 'latest_begin', 5, 23,intval(lade_db_einstellung('latest_begin')), '', '', '');
$SettingTableItems .= table_form_string_item('Website Men&uuml;farbe', 'site_menue_color', lade_db_einstellung('site_menue_color'), false);
$SettingTableItems .= table_form_string_item('Website Footerfarbe', 'site_footer_color', lade_db_einstellung('site_footer_color'), false);
$SettingTableItems .= table_form_string_item('Farbe Link Buttons', 'site_buttons_color', lade_db_einstellung('site_buttons_color'), false);
$SettingTableItems .= table_form_string_item('Farbe Error Buttons', 'site_error_buttons_color', lade_db_einstellung('site_error_buttons_color'), false);


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