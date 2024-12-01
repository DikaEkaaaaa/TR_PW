<?php
session_start();
require '../../db.php';

// Periksa apakah user memiliki role employer
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Employer') {
    header("Location: login.php");
    exit();
}

$job_id = $_GET['id'] ?? 0;

// Hapus pekerjaan dari database
$stmt = $conn->prepare("DELETE FROM tb_jobs WHERE id = ? AND created_by = ?");
$stmt->bind_param("ii", $job_id, $_SESSION['user_id']);

if ($stmt->execute()) {
    echo "<script>alert('Job deleted successfully!'); window.location.href = 'dashboard.php';</script>";
} else {
    echo "<script>alert('Failed to delete job.'); window.location.href = 'dashboard.php';</script>";
}
?>
