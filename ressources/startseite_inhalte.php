<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 13.06.18
 * Time: 15:24
 */

function startseite_inhalt_home(){

    #Parallax 1
    $ParallaxText1Content = '<div class="section no-pad-bot">
      <div class="container">
        <br><br>
        <h1 class="header center teal-text text-lighten-2">Parallax Template</h1>
        <div class="row center">
          <h5 class="header col s12 light">A modern responsive front-end framework based on Material Design</h5>
        </div>
        <div class="row center">
          <a href="http://materializecss.com/getting-started.html" id="download-button" class="btn-large waves-effect waves-light teal lighten-1">Get Started</a>
        </div>
        <br><br>

      </div>
    </div>';
    $Parallax1Content = '<img src="/media/background1.jpg" alt="Unsplashed background img 1">';
    $Parallax1 = parallax_content_builder($Parallax1Content);
    $HTML = parallax_container(($ParallaxText1Content.$Parallax1));

    # Row Container
    $Row1Content = " <!--   Icon Section   -->
      <div class=\"row\">
        <div class=\"col s12 m4\">
          <div class=\"icon-block\">
            <h2 class=\"center brown-text\"><i class=\"material-icons\">flash_on</i></h2>
            <h5 class=\"center\">Speeds up development</h5>

            <p class=\"light\">We did most of the heavy lifting for you to provide a default stylings that incorporate our custom components. Additionally, we refined animations and transitions to provide a smoother experience for developers.</p>
          </div>
        </div>

        <div class=\"col s12 m4\">
          <div class=\"icon-block\">
            <h2 class=\"center brown-text\"><i class=\"material-icons\">group</i></h2>
            <h5 class=\"center\">User Experience Focused</h5>

            <p class=\"light\">By utilizing elements and principles of Material Design, we were able to create a framework that incorporates components and animations that provide more feedback to users. Additionally, a single underlying responsive system across all platforms allow for a more unified user experience.</p>
          </div>
        </div>

        <div class=\"col s12 m4\">
          <div class=\"icon-block\">
            <h2 class=\"center brown-text\"><i class=\"material-icons\">settings</i></h2>
            <h5 class=\"center\">Easy to work with</h5>

            <p class=\"light\">We have provided detailed documentation as well as specific code examples to help new users get started. We are also always open to feedback and can answer any questions a user may have about Materialize.</p>
          </div>
        </div>
      </div>
";
    $SectionRow1Content = section_builder($Row1Content);
    $ContainerRow1Content = container_builder($SectionRow1Content);

    $HTML .= $ContainerRow1Content;

    return $HTML;
}