<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 13.06.18
 * Time: 15:24
 */

function startseite_inhalt_home(){

    #Parallax 1
    $Section1Content = '<br><br><h1 class="header center teal-text text-lighten-2">Parallax Template</h1>
        <div class="row center">
          <h5 class="header col s12 light">A modern responsive front-end framework based on Material Design</h5>
        </div>
        <div class="row center">
          <a href="http://materializecss.com/getting-started.html" id="download-button" class="btn-large waves-effect waves-light teal lighten-1">Get Started</a>
        </div>
        <br><br>';
    $Section1ContentContainer = container_builder($Section1Content);
    $Section1 = section_builder($Section1ContentContainer, '', 'no-pad-bot');
    $Parallax1Content = '<img src="/media/background1.jpg" alt="Unsplashed background img 1">';
    $Parallax1 = parallax_content_builder($Parallax1Content);

    $HTML = parallax_container(($Section1.$Parallax1));

    return $HTML;
}