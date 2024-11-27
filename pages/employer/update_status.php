<?php
session_start();
require '../../db.php';

// Periksa apakah user memiliki role employer
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Employer') {
    header("Location: login.php");
    exit();
}

// Update status pendaftar
$applicant_id = $_GET['id'] ?? 0;
$status = $_GET['status'] ?? '';

if ($status === 'lolos' || $status === 'tidak') {
    $stmt = $conn->prepare("UPDATE tb_applicants SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $applicant_id);

    if ($stmt->execute()) {
        echo "<script>alert('Status updated successfully!'); history.back();</script>";
    } else {
        echo "<script>alert('Failed to update status.'); history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid status.'); history.back();</script>";
}
?>
