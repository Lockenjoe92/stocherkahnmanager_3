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

    if (!($stmt = $link->prepare("INSERT INTO protocol (user,protocol,message,timestamp) VALUES (?,?,?,?)"))) {
        echo "Prepare failed: (" . $link->errno . ") " . $link->error;
    }
    if (!$stmt->bind_param("isss", lade_user_id(), $protocol_type, $message, timestamp())) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

}