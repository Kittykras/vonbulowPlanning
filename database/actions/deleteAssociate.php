<?php

require_once '../DBConnection.php';

function htmlEntities2($str) {
    $text = str_replace("oe", "ø", $str);
    $text = str_replace("aaa", "å", $text);
    $text = str_replace("ae", "æ", $text);
//    window.alert(text);
    return $text;
}

try {
    $delName = htmlEntities2($_COOKIE["UserName"]);
    $db = new DBConnection();
    $q = "call deleteassociate(:delName);";
    $stmt = $db->prepare($q);
    $stmt->execute(array(":delName" => $delName));
    $count = $stmt->rowCount();
    if ($stmt != FALSE) {
        header("location:../../associates.php");
    } else {
        header("location:../../singleAssociate.php?error");
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

