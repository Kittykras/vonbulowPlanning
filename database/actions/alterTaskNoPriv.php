<?php

require_once '../DBConnection.php';
$session_expiration = time() + 3600 * 24; // +1 days
session_set_cookie_params($session_expiration);
session_start();
try {
    $user = $_SESSION["user"]->a_username;
    $id = $_COOKIE["Task"];
    $cus = $_POST["cus"];
    $stat = $_POST["stat"];
    $timespen = $_POST["hour"] . ":" . $_POST["min"];
    $comment = $_POST["newComment"];
    $press = isset($_POST['press']) && $_POST['press'] ? "true" : "false";
    $db = new DBConnection();
    $q = "call altertasknopriv(:id, :stat, :timespent, :press)";
    $stmt = $db->prepare($q);
    $stmt->execute(array(':id' => $id, ':stat' => $stat, ':timespent' => $timespen, ':press' => $press));
//    $count = $stmt->rowCount();
//    $commentcount = 0;
    if ($comment != "") {
        $q = "call createcomment(:id, :comment, :user);";
        $stmt = $db->prepare($q);
        $stmt->execute(array(':id' => $id, ':comment' => $comment, ":user" => $user));
        if ($mailto != "") {
            $q = "call getAssociate(:mailto)";
            $stmt = $db->prepare($q);
            $stmt->execute(array(':mailto' => $mailto));
            $asmail = $stmt->fetch(PDO::FETCH_OBJ);
            sendmail($asmail->a_email, 'Ny kommentar på en opgave', 'Kunde: ' . $cus . '<br><br>Opgave: ' . $title . '<br><br>' . $user . ' har tilføjet en kommentar:<br>' . $comment);
        }
    }
    if ($stmt != FALSE) {
        setcookie('Kunde', $cus, time() + (86400), "/planning/");
        header("location:" . $_COOKIE['previous']);
    } else {
        header("location:../../taskForm.php?edit&error");
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}