<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 31.05.19
 * Time: 20:58
 */

include_once "./ressourcen.php";

function add_protocol_entry($message, $protocol_type){

    echo "xkhbs";

    $link = connect_db();

    $timestamp = "2019-06-09 23:45:44";
    $userID = 2;

    echo $message;
    echo $protocol_type;

    if (!($stmt = $link->prepare("INSERT INTO protocol ('user',protocol,message,'timestamp') VALUES (?,?,?,?)"))) {
        echo "Prepare failed: (" . $link->errno . ") " . $link->error;
    }
    if (!$stmt->bind_param("isss", $userID, $protocol_type, $message, $timestamp)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

}