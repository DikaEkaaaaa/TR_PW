<?php
session_start();
require '../../db.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$job_id = $_GET['job_id'] ?? null;

if (!$job_id) {
    header("Location: index.php");
    exit();
}

// Hapus lamaran pekerjaan
$remove_application = $conn->prepare("DELETE FROM tb_applications WHERE job_id = ? AND user_id = ?");
$remove_application->bind_param("ii", $job_id, $user_id);

if ($remove_application->execute()) {
    header("Location: index.php"); // Kembali ke halaman utama setelah menghapus lamaran
    exit();
} else {
    echo "<script>alert('Error removing application.'); window.location.href='index.php';</script>";
    exit();
}
?>
