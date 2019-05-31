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

function table_builder($ContentHTML){

    $HTML = "<table>";
    $HTML .= $ContentHTML;
    $HTML .= "</table>";

    return $HTML;
}

function form_button_builder($ButtonName, $ButtonMessage, $ButtonMode, $Icon, $SpecialMode=''){

    return "<button class='btn waves-effect waves-light ".$SpecialMode."' type='".$ButtonMode."' name='".$ButtonName."'>".$ButtonMessage."<i class='material-icons left'>".$Icon."</i></button>";

}

function form_switch_item($ItemName, $OptionLeft='off', $OptionRight='on', $BooleanText='false', $Disabled=false){

    $HTML = "<div class='switch'>";
    $HTML .= "<label>";
    $HTML .= $OptionLeft;

    if ($BooleanText == 'false'){
        $PresetMode = '';
    } elseif ($BooleanText == 'true'){
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

function table_form_swich_item($ItemTitle, $ItemName, $OptionLeft='off', $OptionRight='on', $BooleanText='false', $Disabled=false){

    return "<tr><th>".$ItemTitle."</th><td>".form_switch_item($ItemName, $OptionLeft, $OptionRight, $BooleanText, $Disabled)."</td></tr>";

}

function table_form_string_item($ItemTitle, $ItemName, $Placeholdertext='', $Disabled=false){

    return "<tr><th>".$ItemTitle."</th><td>".form_string_item($ItemName, $Placeholdertext, $Disabled)."</td></tr>";

}

function table_form_range_item($ItemTitle, $ItemName, $Min, $Max, $StartValue, $Disabled=false){

    return "<tr><th>".$ItemTitle."</th><td>".form_range_item($ItemName, $Min, $Max, $StartValue, $Disabled=false)."</td></tr>";

}

function toast($Message){
    return "<script>M.toast({html: ".$Message."})</script>";
}

?>