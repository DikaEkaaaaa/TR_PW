<?php
session_start();
require '../../db.php';

if (isset($_SESSION['user_id']) && isset($_GET['job_id'])) {
    $user_id = $_SESSION['user_id'];
    $job_id = $_GET['job_id'];

    $checkQuery = "SELECT id FROM tb_applications WHERE user_id = ? AND job_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $user_id, $job_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $insertQuery = "INSERT INTO tb_applications (user_id, job_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ii", $user_id, $job_id);
        $stmt->execute();
        echo "<script>alert('You have successfully applied for this job!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('You have already applied for this job!'); window.location.href='index.php';</script>";
    }
} else {
    echo "Please log in first.";
}
