<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 15.10.18
 * Time: 18:04
 */

# Include all ressources
include_once "./ressources/ressourcen.php";

#Generate Content
$Header = "Login - " . lade_xml_einstellung('site_name', 'local');
$HTML = login_formular();

# Output site
echo site_header($Header);
echo site_body($HTML);

?>