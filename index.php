<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 12.06.18
 * Time: 18:13
 */

# Include all ressources
include_once "./ressources/ressourcen.php";

# Generate Content
$HTML = startseite_inhalt_home();

# Output site
echo site_header('Stocherkahn Medizin Tübingen e.V.');
echo site_body($HTML);

?>