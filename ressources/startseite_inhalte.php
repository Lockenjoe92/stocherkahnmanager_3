<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 13.06.18
 * Time: 15:24
 */

function startseite_inhalt_home(){

    #Parallax 1
    $Section1Content = '';
    $Section1ContentContainer = container_builder($Section1Content);
    $Section1 = section_builder($Section1ContentContainer, '', 'no-pad-bot');
    $Parallax1Content = '';
    $Parallax1 = parallax_content_builder($Parallax1Content);

    $HTML = parallax_container(($Section1.$Parallax1));

    return $HTML;
}