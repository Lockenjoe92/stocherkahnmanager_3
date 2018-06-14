<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 14.06.18
 * Time: 23:31
 */

function connect_db(){

    $host = '10.35.249.162:3306';
    $user = 'stochertool';
    $pswd = '7**22dZ9uj';
    $name = 'stocherkahnmanager_3-0';

    $sql = new mysqli($host,$user,$pswd,$name);

    /* check for an error code */
    if ( mysqli_connect_errno() ) {
        /* oh no! there was an error code, what's the problem?! */
        echo 'There was an error with your connection: '.mysqli_connect_error();
    }

    return $sql;

}

?>