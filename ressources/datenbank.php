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
    $pswd = '7*X81otp';
    $name = 'stocherkahnmanager_3-0';

    $link = mysqli_connect($host, $user, $pswd, $name);

    if ($link->connect_errno) {
        echo("Connect failed: ".$link->connect_error."");
    }

    return $link;

}

?>