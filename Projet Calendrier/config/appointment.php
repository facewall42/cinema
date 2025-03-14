<?php
//creation d'un rendez vous 
require 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $therapist_id = $_POST['therapist_id'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $sql = "INSERT INTO appointments (user_id, therapist_id, start_time, end_time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $user_id, $therapist_id, $start_time, $end_time);

    if ($stmt->execute()) {
        echo "Rendez-vous créé avec succès!";
    } else {
        echo "Erreur: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>