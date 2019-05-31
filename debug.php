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

$message = "Test1";
$protocol_type = "sessoin";

add_protocol_entry($message, $protocol_type);

?>