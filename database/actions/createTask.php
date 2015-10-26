<?php
require_once '../DBConnection.php';

try{
    $user = print_r($_SESSION["user"]->a_username);
    $cus = $_COOKIE["Kunde"];
    $title = $_POST["title"];
    $descr = $_POST["descr"];
    $stat = $_POST["stat"];
    $assi = $_POST["assi"];
    $timespen = $_POST["hour"].":".$_POST["min"];
    $from = $_POST["from"];
    $to = $_POST["to"];
    $comment = $_POST["comment"];
    echo $user;
    $db = new DBConnection();
    $q = "call createtask(:cus, :title, :descr, :stat, :assi, :timespent, :from, :to);";
    $stmt = $db->prepare($q);
    $stmt->execute(array(':cus' => $cus, ':title' => $title, ':descr' => $descr, ':stat' => $stat, ':assi' => $assi, ':timespent' => $timespen, ':from' => $from, ':to' => $to));
    $count = $stmt->rowCount();
    $q = "call createcommentonnewtask(:comment, :user);";
    $stmt = $db->prepare($q);
    $stmt->execute(array(':comment' => $comment, ":user" => $user));
    if($count == 1){
//        header("location:../../enkeltKunde.php");
    } else {
        header("location:../../opretOpgave.php?error");
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}