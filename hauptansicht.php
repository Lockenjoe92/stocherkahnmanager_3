<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 12.11.18
 * Time: 13:24
 */

include_once "./ressources/ressourcen.php";
session_manager();

echo "Hello logged in user";
echo "<a href='./admin_settings.php'>Admin Settings</a>";

?>
