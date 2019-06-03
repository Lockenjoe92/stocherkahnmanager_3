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

    #Build Card Content
    $ContentHTML = generate_bausteine_view($Ergebnis['name']);
    $ContentHTML .= section_builder(generate_move_buttons_page_level($Anzahl, $ZeroRangCounter, $Ergebnis['menue_rang'], $Ergebnis['menue_text']));

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
            $DownToo = false;

            #Can be moved down
            if($AktuellerRang < $NumberRankedSites){
                $ButtonDownName = "decrease_rank_".$AktuellerName."";
                $HTML .= "<button class='btn waves-effect waves-light col s5' id='".$ButtonDownName."' name='".$ButtonDownName."'><i class='material-icons'>arrow_downward</i> Rang senken</button>";
                $DownToo = True;
            }

            #Can be moved up
            if($AktuellerRang > 1){
                $ButtonDownName = "increase_rank_".$AktuellerName."";
                if($DownToo){
                    $HTML .= "<button class='btn waves-effect waves-light col s5 offset-s1' id='".$ButtonDownName."' name='".$ButtonDownName."'><i class='material-icons'>arrow_upward</i> Rang erhöhen</button>";
                } else {
                    $HTML .= "<button class='btn waves-effect waves-light col s5' id='".$ButtonDownName."' name='".$ButtonDownName."'><i class='material-icons'>arrow_upward</i> Rang erhöhen</button>";
                }
            }

            $HTML = row_builder($HTML);

            return $HTML;
        }
    }
}

function generate_bausteine_view($Seite){

    $link = connect_db();
    $BausteineHTML = "";

    # Load Subsites
    $Anfrage = "SELECT * FROM homepage_bausteine WHERE storno_user = 0 AND ort = '".$Seite."' ORDER BY rang ASC";
    $Abfrage = mysqli_query($link, $Anfrage);
    $Anzahl = mysqli_num_rows($Abfrage);

    for ($x=1;$x<=$Anzahl;$x++){

        $Ergebnis = mysqli_fetch_assoc($Abfrage);
        $Header = "".$Ergebnis['rang']." - ".$Ergebnis['typ']." - ".$Ergebnis['typ']."";
        $Items = generate_inhalte_views($Ergebnis['id']);

        $BausteineHTML .= section_builder(collection_with_header_builder($Header, $Items));

    }

    return $BausteineHTML;
}

function generate_inhalte_views($BausteinID){

    return "TESTtestTEST";

}

?>