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

    # Output site
    $HTML = container_builder($HTML, 'websiteinhalt_bearbeiten_container');
    echo site_header($Header);
    echo site_body($HTML);

} else {
    header("Location: ./admin_edit_startpage.php");
    die();
}