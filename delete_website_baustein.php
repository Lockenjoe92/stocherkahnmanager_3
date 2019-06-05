<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 05.06.19
 * Time: 16:31
 */


include_once "./ressources/ressourcen.php";
session_manager('ist_admin');
$link = connect_db();
$Baustein = $_GET['baustein'];

if(intval($Baustein)>0){
    var_dump($Baustein);
    startseitenelement_loeschen($Baustein);
    header("Location: ./admin_edit_startpage.php");
    die();
} else {
    echo "Error";
}