<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 13.06.18
 * Time: 15:28
 */

function parallax_container($ContentHTML, $ID='', $SpecialMode=''){

    if ($ID!=''){
        $HTML = '<div id="'.$ID.'" class="parallax-container '.$SpecialMode.'">';
    } else {
        $HTML = '<div class="parallax-container '.$SpecialMode.'">';
    }
    $HTML .= $ContentHTML;
    $HTML .= '</div>';

    return $HTML;
}

function parallax_content_builder($ContentHTML, $ID='', $SpecialMode=''){

    if ($ID!=''){
        $HTML = ' <div id="'.$ID.'" class="parallax '.$SpecialMode.'">';
    } else {
        $HTML = ' <div class="parallax '.$SpecialMode.'">';
    }

    $HTML .= $ContentHTML;
    $HTML .= '</div>';

    return $HTML;
}

function row_builder($ContentHTML, $ID='', $SpecialMode=''){

    if ($ID!=''){
        $HTML = ' <div id="'.$ID.'" class="row '.$SpecialMode.'">';
    } else {
        $HTML = ' <div class="row '.$SpecialMode.'">';
    }

    $HTML .= $ContentHTML;
    $HTML .= '</div>';

    return $HTML;

}

function section_builder($ContentHTML, $ID='', $SpecialMode=''){

    if ($ID!=''){
        $HTML = ' <div id="'.$ID.'" class="section '.$SpecialMode.'">';
    } else {
        $HTML = ' <div class="section '.$SpecialMode.'">';
    }

    $HTML .= $ContentHTML;
    $HTML .= '</div>';

    return $HTML;
}

function container_builder($ContentHTML, $ID='', $SpecialMode=''){

    if ($ID!=''){
        $HTML = ' <div id="'.$ID.'" class="container '.$SpecialMode.'">';
    } else {
        $HTML = ' <div class="container '.$SpecialMode.'">';
    }

    $HTML .= $ContentHTML;
    $HTML .= '</div>';

    return $HTML;

}

function form_builder($ContentHTML, $ActionPageLink, $FormMode='post', $ID=''){

    if ($ID == ''){
        $HTML = "<form action='".$ActionPageLink."' method='".$FormMode."'>";
    } else {
        $HTML = "<form action='".$ActionPageLink."' method='".$FormMode."' id='".$ID."'>";
    }

    $HTML .= $ContentHTML;
    $HTML .= "</form>";

    return $HTML;

}

function collection_builder($ListElements){

    $HTML = "<ul class='collection'>";
    $HTML .= $ListElements;
    $HTML .= "</ul>";

    return $HTML;

}

function collection_with_header_builder($Header, $ListElements){

    $HTML = "<ul class='collection with-header'>";
    $HTML .= "<li class='collection-header'><h5>".$Header."</h5></li>";
    $HTML .= $ListElements;
    $HTML .= "</ul>";

    return $HTML;

}

function collection_item_builder($ItemContent){

    $HTML = "<li class='collection-item'>".$ItemContent."</li>";
    return $HTML;

}

function collapsible_builder($ListElements){

    $HTML = "<ul class='collapsible'>";
    $HTML .= $ListElements;
    $HTML .= "</ul>";

    return $HTML;

}

function collapsible_item_builder($Title, $Content, $Icon){

    if($Icon == ''){$IconHTML = '';} else {$IconHTML = "<i class='material-icons'>".$Icon."</i>";}

    $HTML = "<li>";
    $HTML .= "<div class='collapsible-header'>".$IconHTML."".$Title."</div>";
    $HTML .= "<div class='collapsible-body'><span>".$Content."</span></div>";
    $HTML .= "</li>";

    return $HTML;

}

function table_builder($ContentHTML){

    $HTML = "<table>";
    $HTML .= $ContentHTML;
    $HTML .= "</table>";

    return $HTML;
}

function table_row_builder($ContentHTML){

    return "<tr>".$ContentHTML."</tr>";
}

function table_data_builder($ContentHTML){

    return "<td>".$ContentHTML."</td>";
}

function form_button_builder($ButtonName, $ButtonMessage, $ButtonMode, $Icon, $SpecialMode=''){

    return "<button class='btn waves-effect waves-light ".lade_db_einstellung('site_buttons_color')." ".$SpecialMode."' type='".$ButtonMode."' name='".$ButtonName."'>".$ButtonMessage."<i class='material-icons left'>".$Icon."</i></button>";

}

function form_switch_item($ItemName, $OptionLeft='off', $OptionRight='on', $BooleanText='off', $Disabled=false){

    $HTML = "<div class='switch'>";
    $HTML .= "<label>";
    $HTML .= $OptionLeft;

    if ($BooleanText == 'off'){
        $PresetMode = '';
    } elseif ($BooleanText == 'on'){
        $PresetMode = 'checked';
    }

    if ($Disabled == true){
        $HTML .= "<input name='".$ItemName."' id='".$ItemName."' disabled type='checkbox' ".$PresetMode.">";
    } elseif($Disabled == false) {
        $HTML .= "<input name='".$ItemName."' id='".$ItemName."' type='checkbox' ".$PresetMode.">";
    }

    $HTML .= "<span class='lever'></span>";

    $HTML .= $OptionRight;
    $HTML .= "</label>";
    $HTML .= "</div>";

    return $HTML;
}

function form_string_item($ItemName, $Placeholdertext='', $Disabled=false){

    if ($Disabled == false) {
        $DisabledCommand = '';
    } elseif ($Disabled == true){
        $DisabledCommand = 'disabled';
    }

    if ($Placeholdertext==''){
        return "<input ".$DisabledCommand." id='".$ItemName."' name='".$ItemName."' type='text' class='validate'>";
    } else {
        return "<input ".$DisabledCommand." value='".$Placeholdertext."' id='".$ItemName."' name='".$ItemName."' type='text' class='validate'>";
    }

}

function form_range_item($ItemName, $Min, $Max, $StartValue, $Disabled=false){

    if ($Disabled == false){
        $DisabledCommand = '';
    } elseif ($Disabled == true){
        $DisabledCommand = 'disabled';
    }

    $HTML = "<p class='range-field'>";
    $HTML .= "<input ".$DisabledCommand." type='range' id='".$ItemName."' value='".$StartValue."' min='".$Min."' max='".$Max."'/>";
    $HTML .= "</p>";

    return $HTML;

}

function form_select_item($ItemName, $Min=0, $Max=0, $StartValue='', $Einheit='', $Label='', $SpecialMode='', $Disabled=false){

    $HTML = "<div class='input-field' ".$SpecialMode.">";
    $HTML .= "<select id='".$ItemName."' name='".$ItemName."' class='browser-default'>";

    if ($Disabled == false){
        $DisabledCommand = '';
    } elseif ($Disabled == true){
        $DisabledCommand = 'disabled';
    }

    if($StartValue == ''){
        $HTML .= "<option value='' disabled selected>Bitte w&auml;hlen</option>";
    } else {
        $HTML .= "<option value='' disabled>Bitte w&auml;hlen</option>";
    }

    for ($x=$Min;$x<=$Max;$x++) {

        if ($StartValue == $x) {
            $HTML .= "<option value='" . $x . "' " . $DisabledCommand . " selected>" . $x . " " . $Einheit . "</option>";
        } else {
            $HTML .= "<option value='" . $x . "' " . $DisabledCommand . ">" . $x . " " . $Einheit . "</option>";
        }
    }

    $HTML .= "</select>";

    if ($Label!=''){
        $HTML .= "<label>".$Label."</label>";
    }

    $HTML .= "</div>";

    return $HTML;
}

function form_html_area_item($ItemName, $Placeholdertext='', $Disabled=false){

    if ($Disabled == false){
        $DisabledCommand = '';
    } elseif($Disabled == true) {
        $DisabledCommand = 'disabled';
    }

    $HTML = "<div class='input-field col s12'>";
    $HTML .= "<textarea id='".$ItemName."' name='".$ItemName."' class='materialize-textarea' placeholder='".$Placeholdertext."' ".$DisabledCommand.">";
    $HTML .= "<pre><code>";
    $HTML .= $Placeholdertext;
    $HTML .= "</code></pre>";
    $HTML .= "</textarea>";
    $HTML .= "</div>";

    return $HTML;

}

function table_form_swich_item($ItemTitle, $ItemName, $OptionLeft='off', $OptionRight='on', $BooleanText='false', $Disabled=false){

    return "<tr><th>".$ItemTitle."</th><td>".form_switch_item($ItemName, $OptionLeft, $OptionRight, $BooleanText, $Disabled)."</td></tr>";

}

function table_form_string_item($ItemTitle, $ItemName, $Placeholdertext='', $Disabled=false){

    return "<tr><th>".$ItemTitle."</th><td>".form_string_item($ItemName, $Placeholdertext, $Disabled)."</td></tr>";

}

function table_form_range_item($ItemTitle, $ItemName, $Min, $Max, $StartValue, $Disabled=false){

    return "<tr><th>".$ItemTitle."</th><td>".form_range_item($ItemName, $Min, $Max, $StartValue, $Disabled)."</td></tr>";

}

function table_form_select_item($ItemTitle, $ItemName, $Min, $Max, $StartValue, $Einheit, $Label, $SpecialMode, $Disabled=false){

    return "<tr><th>".$ItemTitle."</th><td>".form_select_item($ItemName, $Min, $Max, $StartValue, $Einheit, $Label, $SpecialMode, $Disabled)."</td></tr>";

}

function table_form_html_area_item($ItemTitle, $ItemName, $Placeholdertext='', $Disabled=false){

    return "<tr><th>".$ItemTitle."</th><td>".form_html_area_item($ItemName, $Placeholdertext, $Disabled)."</td></tr>";

}

function button_link_creator($ButtonMessage, $ButtonLink, $Icon, $SpecialMode){

    return "<a href='".$ButtonLink."' class='waves-effect waves-light btn ".lade_db_einstellung('site_buttons_color')." ".$SpecialMode."'><i class='material-icons left'>".$Icon."</i>".$ButtonMessage."</a>";

}

function error_button_creator($ButtonMessage, $Icon, $SpecialMode){

    return "<a href='#' class='waves-effect waves-light btn ".lade_db_einstellung('site_error_buttons_color')." ".$SpecialMode."'><i class='material-icons left'>".$Icon."</i>".$ButtonMessage."</a>";

}

function divider_builder(){

    $HTML = "<div class='divider'></div>";

    return $HTML;
}

function toast($Message){
    return "<script>M.toast({html: ".$Message."})</script>";
}

?>