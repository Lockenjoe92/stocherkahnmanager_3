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
    $ContentHTML .= generate_baustein_adder($Ergebnis['name']);
    $ContentHTML .= section_builder(generate_move_buttons_page_level($Anzahl, $ZeroRangCounter, $Ergebnis['menue_rang'], $Ergebnis['menue_text']));

    #Build the Item
    $CollapsibleItems .= collapsible_item_builder($TitleHTML, $ContentHTML, 'pageview');

}

#Include Add Page functionality
$CollapsibleItems .= generate_collapsible_add_page_item();

#Wrap Collapsibles
$CollapsibleList = collapsible_builder($CollapsibleItems);
$HTML .= section_builder($CollapsibleList);
$HTML = container_builder($HTML, 'admin_edit_startpage_container', '');

# Output site
echo site_header($Header);
echo site_body($HTML);

function generate_bausteine_view($Seite){

    $link = connect_db();
    $BausteineHTML = "";

    # Load Subsites
    $Anfrage = "SELECT * FROM homepage_bausteine WHERE storno_user = 0 AND ort = '".$Seite."' ORDER BY rang ASC";
    $Abfrage = mysqli_query($link, $Anfrage);
    $Anzahl = mysqli_num_rows($Abfrage);

    if ($Anzahl == 0){
        $Header = "Bislang noch keine Bausteine hinzugefügt!";
        $BausteineHTML .= section_builder(collection_with_header_builder($Header, ''));
    } else {
        for ($x = 1; $x <= $Anzahl; $x++) {

            $Ergebnis = mysqli_fetch_assoc($Abfrage);
            $ReferenceDelete = "./delete_website_baustein_".$Ergebnis['id']."";
            $Operators = "<a href='".$ReferenceDelete."'><i class='tiny material-icons'>delete_forever</i></a> ";
            $Operators .= generate_move_buttons_baustein_level($Anzahl, $Ergebnis['id'], $Ergebnis['rang'], $Seite);

            $Header = "" . $Ergebnis['rang'] . " - " . $Ergebnis['typ'] . " - " . $Ergebnis['name'] . " ".$Operators."";
            $Items = generate_inhalte_views($Ergebnis['id']);

            $BausteineHTML .= section_builder(collection_with_header_builder($Header, $Items));

        }
    }

    return $BausteineHTML;
}

function generate_inhalte_views($BausteinID){

    $link = connect_db();
    $InhalteHTML = "";
    $Baustein = lade_baustein($BausteinID);

    # Load Content
    $Anfrage = "SELECT * FROM homepage_content WHERE storno_user = 0 AND id_baustein = '".$BausteinID."' ORDER BY rang ASC";
    $Abfrage = mysqli_query($link, $Anfrage);
    $Anzahl = mysqli_num_rows($Abfrage);

    if ($Anzahl == 0){
        $Header = "Bislang noch keine Inhaltselemente hinzugefügt!";
        $InhalteHTML .= collection_item_builder($Header);
    } else {
        for ($x=1;$x<=$Anzahl;$x++){

            $Ergebnis = mysqli_fetch_assoc($Abfrage);
            $ReferenceEdit = "./edit_website_item_".$Ergebnis['id']."";
            $ReferenceDelete = "./delete_website_item_".$Ergebnis['id']."";

            if($Baustein['typ'] == 'parallax_mit_text'){
                $Operators = "<a href='".$ReferenceEdit."'><i class='tiny material-icons'>edit</i></a> ";
                $Operators .= generate_move_buttons_item_level($Anzahl, $Ergebnis['id'], $Ergebnis['rang'], $Ergebnis['id_baustein']);
                $Header = "".$Ergebnis['rang']." - ".$Ergebnis['ueberschrift']." - ".$Ergebnis['zweite_ueberschrift']." ".$Operators."";
            } elseif ($Baustein['typ'] == 'row_container'){
                $Operators = "<a href='".$ReferenceEdit."'><i class='tiny material-icons'>edit</i></a> <a href='".$ReferenceDelete."'><i class='tiny material-icons'>delete_forever</i></a> ";
                $Operators .= generate_move_buttons_item_level($Anzahl, $Ergebnis['id'], $Ergebnis['rang'], $Ergebnis['id_baustein']);
                $Header = "".$Ergebnis['rang']." - ".$Ergebnis['ueberschrift']." ".$Operators."";
            }

            $InhalteHTML .= collection_item_builder($Header);

        }
    }

    return $InhalteHTML;

}

function generate_bausteine_dropdown_menue($ItemName, $Label, $SpecialMode){

    $HTML = "<div class='input-field' ".$SpecialMode.">";
    $HTML .= "<select id='".$ItemName."' name='".$ItemName."'>";

    $HTML .= "<option value='' disabled selected>Bitte w&auml;hlen</option>";
    $HTML .= "<option value='row_container'>row_container</option>";
    $HTML .= "<option value='parallax_mit_text'>parallax_mit_text</option>";
    $HTML .= "</select>";

    if ($Label!=''){
        $HTML .= "<label>".$Label."</label>";
    }

    $HTML .= "</div>";

    return $HTML;
}

function generate_baustein_adder($SiteName){

    $NameNewBaustein = "name_new_baustein_".$SiteName."";
    $TypeNewBaustein = "type_new_baustein_".$SiteName."";
    $NameAddButtonBaustein = "add_new_baustein_".$SiteName."";

    $HTML = row_builder(divider_builder());
    $HTML .= row_builder('<h4>Baustein hinzufügen</h4>');
    $HTML .= row_builder(generate_bausteine_dropdown_menue($TypeNewBaustein, 'Baustein wählen', ''));
    $HTML .= row_builder(form_string_item($NameNewBaustein, 'gib dem Element einen Namen', ''));
    $HTML .= row_builder(form_button_builder($NameAddButtonBaustein, 'Hinzufügen', 'action', 'add_box', ''));

    $HTML = section_builder($HTML);

    return $HTML;
}

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

            $Output = row_builder(divider_builder());
            $Output .= row_builder('<h4>Rang verschieben</h4>');
            $HTML = '';
            $DownToo = false;

            #Can be moved down
            if($AktuellerRang < $NumberRankedSites){
                $ButtonDownName = "decrease_rank_".$AktuellerName."";
                $HTML .= "<button class='btn waves-effect waves-light col s5 ".lade_db_einstellung('site_buttons_color')."' id='".$ButtonDownName."' name='".$ButtonDownName."'><i class='material-icons'>arrow_downward</i> Rang senken</button>";
                $DownToo = True;
            }

            #Can be moved up
            if($AktuellerRang > 1){
                $ButtonDownName = "increase_rank_".$AktuellerName."";
                if($DownToo){
                    $HTML .= "<button class='btn waves-effect waves-light col s5 offset-s1 ".lade_db_einstellung('site_buttons_color')."' id='".$ButtonDownName."' name='".$ButtonDownName."'><i class='material-icons'>arrow_upward</i> Rang erhöhen</button>";
                } else {
                    $HTML .= "<button class='btn waves-effect waves-light col s5 ".lade_db_einstellung('site_buttons_color')."' id='".$ButtonDownName."' name='".$ButtonDownName."'><i class='material-icons'>arrow_upward</i> Rang erhöhen</button>";
                }
            }

            $Output .= row_builder($HTML);

            return $Output;
        }
    }
}

function generate_move_buttons_baustein_level($AnzahlGesamtBausteine, $AktuellerBausteinID, $AktuellerBausteinRang, $AktuelleSeiteName){

    #We are in a site with a rank
    if ($AnzahlGesamtBausteine == 1){
        #This site cannot be moved as it is the only one with a rank
        return '';
    } elseif ($AnzahlGesamtBausteine > 1){

        $HTML = '';

        #Can be moved down
        if($AktuellerBausteinRang < $AnzahlGesamtBausteine){
            $ButtonDownName = "#?decrease_rank_baustein_".$AktuellerBausteinID."_".$AktuelleSeiteName."=true";
            $HTML .= "<a href='".$ButtonDownName."'><i class='tiny material-icons'>arrow_downward</i></a> ";
        }

        #Can be moved up
        if($AktuellerBausteinRang > 1){
            $ButtonDownName = "#?increase_rank_baustein_".$AktuellerBausteinID."_".$AktuelleSeiteName."=true";
            $HTML .= "<a href='".$ButtonDownName."'><i class='tiny material-icons'>arrow_upward</i></a> ";
        }

        return $HTML;
    }
}

function generate_move_buttons_item_level($AnzahlGesamtItems, $AktuellerItemID, $AktuellerItemRang, $AktuellerBaustein){

    #We are in a site with a rank
    if ($AnzahlGesamtItems == 1){
        #This site cannot be moved as it is the only one with a rank
        return '';
    } elseif ($AnzahlGesamtItems > 1){

        $HTML = '';

        #Can be moved down
        if($AktuellerItemRang < $AnzahlGesamtItems){
            $ButtonDownName = "#?decrease_rank_item_".$AktuellerItemID."_".$AktuellerBaustein."=true";
            $HTML .= "<a href='".$ButtonDownName."'><i class='tiny material-icons'>arrow_downward</i></a> ";
        }

        #Can be moved up
        if($AktuellerItemRang > 1){
            $ButtonDownName = "#?increase_rank_item_".$AktuellerItemID."_".$AktuellerBaustein."=true";
            $HTML .= "<a href='".$ButtonDownName."'><i class='tiny material-icons'>arrow_upward</i></a> ";
        }

        return $HTML;
    }
}

function generate_collapsible_add_page_item(){

    $TitleHTML = "Neue Seite anlegen";
    $Icon = "add_box";

    # Form Table
    $TableHTML = table_form_string_item('Seitenname', 'new_site_name', '', false);
    $TableHTML .= table_form_string_item('Titel der Seite', 'new_site_title', '', false);
    $TableHTML .= table_form_swich_item('Sichtbarkeit im Hauptmenü', 'new_site_menue_visibility', 'unsichtbar', 'sichtbar', '', '');
    $TableButtons = table_header_builder('');
    $TableButtons .= table_data_builder(form_button_builder('add_new_site', 'Neue Seite anlegen', 'action', 'add_box', ''));
    $TableHTML .= table_row_builder($TableButtons);
    $ContentHTML = table_builder($TableHTML);

    return collapsible_item_builder($TitleHTML, $ContentHTML, $Icon);
}

?>