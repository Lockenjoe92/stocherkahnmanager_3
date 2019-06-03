<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 03.06.19
 * Time: 13:59
 */

include_once "./ressources/ressourcen.php";
session_manager('ist_admin');
$link = connect_db();
$Header = "Webseite Editieren - " . lade_db_einstellung('site_name');

#Generate content
# Page Title
$PageTitle = '<h1>Webseite Editieren</h1>';
$HTML .= section_builder($PageTitle);

# Load Subsites
$Anfrage = "SELECT * FROM homepage_sites WHERE delete_user = 0 ORDER BY menue_rang ASC";
$Abfrage = mysqli_query($link, $Anfrage);
$Anzahl = mysqli_num_rows($Abfrage);
$CollapsibleItems = '';
$ZeroRangCounter = 0;

for($x=1;$x<=$Anzahl;$x++){

    $Ergebnis = mysqli_fetch_assoc($Abfrage);
    if($Ergebnis['menue_rang'] == intval(0)){$ZeroRangCounter++;}

    #Build Title Content
    $TitleHTML = $Ergebnis['menue_text'];
    $TitleHTML .= generate_move_buttons_page_level($Anzahl, $ZeroRangCounter, $Ergebnis['menue_rang'], $Ergebnis['menue_text']);

    #Build Card Content
    $ContentHTML = "CONTENT";

    #Build the Item
    $CollapsibleItems .= collapsible_item_builder($TitleHTML, $ContentHTML, 'pageview');

}

#Wrap Collapsibles
$CollapsibleList = collapsible_builder($CollapsibleItems);
$HTML .= section_builder($CollapsibleList);
$HTML = container_builder($HTML, 'admin_edit_startpage_container', '');

# Output site
echo site_header($Header);
echo site_body($HTML);


function generate_move_buttons_page_level($AnzahlGesamtSeiten, $ZeroRangCounter, $AktuellerRang, $AktuellerName){

    if ($AktuellerRang == 0){
        #This is a site not to be moved in relevance
        return '';
    } else {

        #NUmber of ranked sites
        $NumberRankedSites = $AnzahlGesamtSeiten - $ZeroRangCounter;

        #We are in a site with a rank
        if ($NumberRankedSites == 1){
            #This site cannot be moved as it is the only one with a rank
            return '';
        } elseif ($NumberRankedSites > 1){

            $HTML = '';

            #Can be moved down
            if($AktuellerRang < $NumberRankedSites){
                $ButtonDownName = "decrease_rank_".$AktuellerName."";
                $HTML .= "<button class='btn' id='".$ButtonDownName."' name='".$ButtonDownName."'><i class='material-icons'>arrow-downward</i> Rang senken</button>";
            }

            #Can be moved up
            if($AktuellerRang > 1){
                $ButtonDownName = "increase_rank_".$AktuellerName."";
                $HTML .= "<button class='btn' id='".$ButtonDownName."' name='".$ButtonDownName."'><i class='material-icons'>arrow-upward</i> Rang erhöhen</button>";
            }

            return $HTML;
        }
    }
}




?>