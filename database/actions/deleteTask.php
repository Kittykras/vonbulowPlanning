<?php

require_once '../DBConnection.php';

try {
    $delName = $_COOKIE["Task"];
    $db = new DBConnection();
    $q = "call deletetask(:delName);";
    $stmt = $db->prepare($q);
    $stmt->execute(array(":delName" => $delName));
    $count = $stmt->rowCount();
    if ($stmt != FALSE) {
        $previous = $_COOKIE['previous'];
        if (strpos($previous, 'associate') != FALSE) {
            setcookie('kunder', '', time() + (86400), "/planning/");
            if ($_COOKIE['UserName'] === $_SESSION["user"]->a_username) {
                setcookie('login', 'active', time() + (86400), "/planning/");
            } else {
                setcookie('medarbejder', 'active', time() + (86400), "/planning/");
            }
        } else if (strpos($previous, 'time') != FALSE) {
            setcookie('kunder', '', time() + (86400), "/planning/");
            setcookie('timeoversigt', 'active', time() + (86400), "/planning/");
        } else if (strpos($previous, 'overview') != FALSE) {
            setcookie('kunder', '', time() + (86400), "/planning/");
            setcookie('overblik', 'active', time() + (86400), "/planning/");
        } else if (strpos($previous, 'press') != FALSE) {
            setcookie('kunder', '', time() + (86400), "/planning/");
            setcookie('presse', 'active', time() + (86400), "/planning/");
        }
        header("location:" . $previous);
    } else {
        header("location:../../taskForm.php?edit&error");
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}