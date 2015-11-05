<?php
require_once '../DBConnection.php';

try{
    $name = $_POST["name"];
    $acro = $_POST["acro"];
    $cont = $_POST["cont"];
    $tlf = $_POST["tlf"];
    $mail = $_POST["mail"];
    $bran = $_POST["bran"];
    $assi= $_POST["assi"];
    $db = new DBConnection();
    $q = "call createcustomer(:acro, :name, :bran, :cont, :tlf, :mail, :assi);";
    $stmt = $db->prepare($q);
    $stmt->execute(array(':acro' => $acro, ':name' => $name, ':bran' => $bran, ':cont' => $cont, ':tlf' => $tlf, ':mail' => $mail, ':assi' => $assi));
    $count = $stmt->rowCount();
    if($count == 1){
        header("location:../../customers.php");
    } else {
        header("location:../../customerForm.php?error");
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}