<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 12.06.18
 * Time: 20:27
 */

function site_header($PageTitle, $LoginCheckActive=Null){

    #Redirect wenn Login erforderlich und login nicht erfolgt
    if($LoginCheckActive == True){
        return null;
    }

    #Initialize HTML
    $HTML = '<!DOCTYPE html>';
    $HTML .= '<html lang="de">';

    #Initialize header
    $HTML .= '<head>';

    #Meta infos
    $HTML .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>';
    $HTML .= '<meta name="viewport" content="width=device-width, initial-scale=1"/>';

    #Page Title
    if(!isset($PageTitle)){$PageTitle = 'Stocherkahnmanager';}
    $HTML .= '<title>'.$PageTitle.'</title>';

    #CSS
    $HTML .= '  <!-- CSS  -->';
    $HTML .= '<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">';
    $HTML .= '<link href="/materialize/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>';
    $HTML .= '<link href="/materialize/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>';

    #End header
    $HTML .= '</head>';

    return $HTML;
}

function site_body($BodyHTMLcontent){

    # Initialize body
    $HTML = '<!--  body  -->';
    $HTML .= '<body>';

    # Add navbar
    $HTML .= site_navbar();

    # Add content
    $HTML .= $BodyHTMLcontent;

    # Add footer
    $HTML .= site_footer();

    # Run skripts
    $HTML .= site_skripts();

    # Close body
    $HTML .= '</body>';

    # End html
    $HTML .= '</html>';

    return $HTML;
}

function site_footer(){

    # Initialize Footer
    $HTML = '<!--  footer-->';
    $HTML .= '<footer class="page-footer teal">';
    $HTML .= footer_container();

    #Close footer
    $HTML .= '</footer>';

    return $HTML;
}

function site_skripts(){

    $HTML = '  <!--  Scripts-->';
    $HTML .= '<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>';
    $HTML .= '<script src="/materialize/js/materialize.js"></script>';
    $HTML .= '<script src="/materialize/js/init.js"></script>';

    return $HTML;
}

function footer_container(){

    #Initialize container
    $HTML = '  <!--  footer container -->';
    $HTML .= '<div class="container">';

    #Initialize row
    $HTML .= '<div class="row">';

    # Gather row content
    $HTML .= footer_content_about();
    $HTML .= footer_content_connect();

    # Close row
    $HTML .= '</div>';

    # Close container
    $HTML .= '</div>';

    # Copyright
    $HTML .= footer_content_copyright();

    return $HTML;
}

function footer_content_about(){

    # Initialize container
    $HTML = '  <!--  content footer about -->';
    $HTML .= '<div class="col l6 s12">';

    # Title
    $HTML .= '<h5 class="white-text">Über uns...</h5>';

    # Text
    $HTML .= '<p class="grey-text text-lighten-4">Ne coole Truppe die Spaß am Kahnfahren hat:)</p>';

    # Close container
    $HTML .= '</div>';

    return $HTML;

}

function footer_content_connect(){

    # Initialize column
    $HTML = '  <!--  content footer connect -->';
    $HTML .= '<div class="col l3 s12">';

    # Content
    $HTML .= '<h5 class="white-text">Connect</h5>';

    # Create list
    $HTML .= '<ul>';
    $HTML .= '<li><a class="white-text" href="#!">Link 1</a></li>';
    $HTML .= '<li><a class="white-text" href="#!">Link 2</a></li>';
    $HTML .= '<li><a class="white-text" href="#!">Link 3</a></li>';
    $HTML .= '<li><a class="white-text" href="#!">Link 4</a></li>';
    $HTML .= '</ul>';

    # Close column
    $HTML .= '</div>';

    return $HTML;

}

function footer_content_copyright(){

    # Initialize copyright div
    $HTML = '  <!--  content footer copyright -->';
    $HTML .= '<div class="footer-copyright">';

    # Open copyright container
    $HTML .= '<div class="container">';
    $HTML .= 'Stocherkahn Medizin Tübingen e.V.';
    $HTML .= '</div>';

    # Close copyright div
    $HTML .= '</div>';

    return $HTML;
}

function site_navbar(){

    $HTML = '<!--  navbar   -->';
    $HTML .= '<nav class="white" role="navigation">';
    $HTML .= '<div class="nav-wrapper container">';

    $HTML .= navbar_links_big();
    $HTML .= navbar_links_mobile();

    $HTML .= '</div>';
    $HTML .= '</nav>';

    return $HTML;
}

function navbar_links_big(){

    $HTML = '<a id="logo-container" href="./index.php" class="brand-logo">Medizinerkahn</a>';
    $HTML .= '<ul class="right hide-on-med-and-down">';
    $HTML .= '<li><a href="#">Kahnverleih</a></li>';
    $HTML .= '<li><a href="#">Verein</a></li>';
    $HTML .= '<li><a href="./login.php">Login</a></li>';
    $HTML .= '</ul>';

    return $HTML;
}

function navbar_links_mobile(){

    $HTML = '<ul id="nav-mobile" class="sidenav">';
    $HTML .= '<li><a href="#">Kahnverleih</a></li>';
    $HTML .= '<li><a href="#">Verein</a></li>';
    $HTML .= '<li><a href="./login.php">Login</a></li>';
    $HTML .= '</ul>';
    $HTML .= '<a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>';

    return $HTML;
}

?>