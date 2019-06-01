<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 15.06.18
 * Time: 00:07
 */

include_once "./ressources/ressourcen.php";

echo "debugging";
$link = connect_db();

$Einstallung = lade_db_einstellung('big_footer_right_column_html');
echo $Einstallung;

?>